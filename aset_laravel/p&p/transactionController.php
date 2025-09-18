<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\MasterEquipment;
use App\Models\VehicleEquiqment;
use App\Models\EmployeeEquipment;
use Illuminate\Support\Facades\DB;
use App\DataTables\transactionDataTable;
use App\Models\transactionDateOfVehicleAndEmployee;

class transactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(transactionDataTable $dataTable)
    {
        $perlengkapan_mobil = MasterEquipment::where('kategori', 'Mobil')->get();
        $perlengkapan_petugas = MasterEquipment::where('kategori', 'Petugas')->get();
        $dataMobil = Vehicle::where('status', 'AKTIF')->where('tipe', 'OPERASIONAL')->get();
        $dataKaryawan = Employee::where('status', 1)->get();
        return $dataTable->render('pages.p&p.viewDataTransaksi', compact('perlengkapan_mobil', 'perlengkapan_petugas', 'dataMobil', 'dataKaryawan'));
    }

    public function get_vehicles(Request $request)
    {
        $tanggalDipilih = Carbon::parse($request->tanggal)->format('Y-m-d');
        $shiftDipilih   = $request->shift;

        $mobilTerpakai = transactionDateOfVehicleAndEmployee::where('tanggal_penjadwalan', $tanggalDipilih)
            ->where('shift', $shiftDipilih)
            ->pluck('id_mobil');


        $dataMobil = Vehicle::with('vehicleClass')
            ->where('status', 'AKTIF')
            ->where('tipe', 'OPERASIONAL')
            ->whereNotIn('nomesin', $mobilTerpakai)
            ->get();

        return response()->json($dataMobil);
    }

    public function get_employee(String $id)
    {
        $transaction = transactionDateOfVehicleAndEmployee::findOrFail($id);

        $tanggal = $transaction->tanggal_penjadwalan;
        $shift = $transaction->shift;

        $petugasTerpakai = transactionDateOfVehicleAndEmployee::whereDate('tanggal_penjadwalan', $tanggal)
            ->where('shift', $shift)
            ->get(['id_petugas_1', 'id_petugas_2', 'id_petugas_3', 'id_petugas_4'])
            ->flatMap(function ($row) {
                return [
                    $row->id_petugas_1,
                    $row->id_petugas_2,
                    $row->id_petugas_3,
                    $row->id_petugas_4,
                ];
            })
            ->filter()   
            ->unique()
            ->toArray();
        $dataPetugas = Employee::where('status', 1)
            ->whereNotIn('id', $petugasTerpakai)
            ->get();

        return response()->json($dataPetugas);
    }

    public function getBarangMobil($id)
    {
        $perlengkapan = VehicleEquiqment::with('master_perlengkapan')->where('monitoring_id', $id)->get();
        $perlengkapanTerpilih = VehicleEquiqment::with('master_perlengkapan')->where('status', 'Completed')->where('monitoring_id', $id)->get();
        return response()->json([
            'perlengkapan' => $perlengkapan,
            'perlengkapanTerpilih' => $perlengkapanTerpilih,
        ]);
    }

    public function getBarangPetugas(String $id)
    {    
         $perlengkapan = EmployeeEquipment::with('master_perlengkapan')->where('monitoring_id', $id)->get();
        $perlengkapanTerpilih = EmployeeEquipment::with('master_perlengkapan')->where('status', 'Completed')->where('monitoring_id', $id)->get();
        return response()->json([
            'perlengkapan' => $perlengkapan,
            'perlengkapanTerpilih' => $perlengkapanTerpilih,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'waktu_pemakaian' => 'required',
                'shift'         => 'required|string',
                'vehicle_id'    => 'required|string|exists:ahs_kendaraan,nomesin',
            ], [
                'vehicle_id.exists' => 'Kendaraan dengan nomor mesin tersebut tidak ditemukan.',
            ]);
            $transaksi = transactionDateOfVehicleAndEmployee::where('id_mobil', $request->vehicle_id)
                ->where('status', 'Beroperasi')
                ->first();
            if ($transaksi) {
                $transaksi->update(['status' => 'Completed']);
            }
            $transaksiBaru = transactionDateOfVehicleAndEmployee::create([
                'tanggal_penjadwalan' => $request->waktu_pemakaian,
                'shift'               => $request->shift,
                'id_mobil'            => $request->vehicle_id,
                'status'              => 'Process',
            ]);
            // Menambahkan perlengkapan mobil and jumlahnya
            if ($request->has('perlengkapan_id_mobil')) {
                foreach ($request->perlengkapan_id_mobil as $loop => $perlengkapanId) {
                    VehicleEquiqment::create([
                        'monitoring_id'   => $transaksiBaru->id,
                        'perlengkapan_id' => $perlengkapanId,
                        'jumlah'         => $request->input('jumlah-mobil.' . $loop) ?? 1,
                        'keterangan'     => null,
                        'status'         => 'Not Completed',
                        'id_user'       => auth()->user()->id,
                        'company_id'    => auth()->user()->company_id,
                    ]);
                }
            }
            DB::commit();
            return redirect()->back()->with('success', 'Transaksi berhasil ditambahkan.');
            
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    public function store_petugas(Request $request, String $id){
        try {
            DB::beginTransaction();
            $transaksi = transactionDateOfVehicleAndEmployee::findOrFail($id);
            $transaksi->update([
                'id_petugas_1' => $request->employe_id1 ?? null,
                'id_petugas_2' => $request->employe_id2 ?? null,
                'id_petugas_3' => $request->employe_id3 ?? null,
                'id_petugas_4' => $request->employe_id4 ?? null,
            ]);
            if ($request->has('perlengkapan_id_petugas')) {
                foreach ($request->perlengkapan_id_petugas as $loop => $perlengkapanId) {
                    EmployeeEquipment::create([
                        'monitoring_id'   => $id,
                        'perlengkapan_id' => $perlengkapanId,
                        'jumlah'         => $request->input('jumlah-petugas.' . $loop) ?? 1,
                        'keterangan'     => null,
                        'status'         => 'Not Completed',
                        'id_user'       => auth()->user()->id,
                        'company_id'    => auth()->user()->company_id,
                    ]);
                }
            }
            DB::commit();
            return redirect()->back()->with('success', 'Transaksi berhasil ditambahkan.');
        } catch (\Throwable $th) {
             DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    public function store_mobil(Request $request){
        try {
            // update checklist
            foreach ($request->barang as $key => $value) {
                VehicleEquiqment::where('id', $value)->update([
                    'status' => 'Completed',
                ]);
            }
            return redirect()->back()->with('success', 'Checklist berhasil disimpan.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $transaksi = transactionDateOfVehicleAndEmployee::with(['vehicle_equiqments'])->findOrFail($id);
        return response()->json([
            'tanggal_penjadwalan' => $transaksi->tanggal_penjadwalan,
            'shift' => $transaksi->shift,
            'id_mobil' => $transaksi->id_mobil,
            'perlengkapan' => $transaksi->vehicle_equiqments->map(function($item) {
                return [
                    'id' => $item->id,
                    'perlengkapan_id' => $item->perlengkapan_id,
                    'jumlah' => $item->jumlah
                ];
            })
    ]);
    }
    public function edit_petugas(string $id)
    {
        $transaksi = transactionDateOfVehicleAndEmployee::with(['employee_equiqments'])->findOrFail($id);
        return response()->json([
                'id_petugas_1' => $transaksi->id_petugas_1,
                'id_petugas_2' => $transaksi->id_petugas_2,
                'id_petugas_3' => $transaksi->id_petugas_3,
                'id_petugas_4' => $transaksi->id_petugas_4,
                'perlengkapan' => $transaksi->employee_equiqments->map(function($item) {
                    return [
                        'id' => $item->id,
                        'perlengkapan_id' => $item->perlengkapan_id,
                        'jumlah' => $item->jumlah
                    ];
                })
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'waktu_pemakaian' => 'required',
                'shift'         => 'required|string',
                'vehicle_id'    => 'required|string|exists:ahs_kendaraan,nomesin',
            ], [
                'vehicle_id.exists' => 'Kendaraan dengan nomor mesin tersebut tidak ditemukan.',
            ]);
            $transaksi = transactionDateOfVehicleAndEmployee::findOrFail($id);

            $transaksi->update([
                'tanggal_penjadwalan' => $request->waktu_pemakaian,
                'shift'               => $request->shift,
                'id_mobil'            => $request->vehicle_id,
            ]);
            // Menambahkan perlengkapan mobil and jumlahnya
            if ($request->has('perlengkapan_item_id')) {
                foreach ($request->perlengkapan_item_id as $loop => $perlengkapanId) {
                    $perlengkapan_mobil = VehicleEquiqment::findOrFail($perlengkapanId);

                    $perlengkapan_mobil->update([
                        'monitoring_id'   => $id,
                        'perlengkapan_id' => $request->perlengkapan_id_mobil[$loop],
                        'jumlah'         => $request->input('jumlah-mobil.' . $loop) ?? 1,
                        'keterangan'     => null,
                        'status'         => 'Not Completed',
                        'id_user'       => auth()->user()->id,
                        'company_id'    => auth()->user()->company_id,
                    ]);
                }
            }
            DB::commit();
            return redirect()->back()->with('success-edit', 'Transaksi berhasil diubah.');

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    public function update_petugas(Request $request, string $id)
    {
        try {
            DB::beginTransaction();
            $transaksi = transactionDateOfVehicleAndEmployee::findOrFail($id);
            $transaksi->update([
                'id_petugas_1' => $request->employe_id1 ?? null,
                'id_petugas_2' => $request->employe_id2 ?? null,
                'id_petugas_3' => $request->employe_id3 ?? null,
                'id_petugas_4' => $request->employe_id4 ?? null,
            ]);
            if ($request->has('perlengkapan_item_id')) {
                foreach ($request->perlengkapan_item_id as $loop => $perlengkapanId) {
                    $perlengkapan_petugas = EmployeeEquipment::findOrFail($perlengkapanId);

                    $perlengkapan_petugas->update([
                        'monitoring_id'   => $id,
                        'perlengkapan_id' => $request->perlengkapan_id_petugas[$loop],
                        'jumlah'         => $request->input('jumlah-petugas.' . $loop) ?? 1,
                        'keterangan'     => null,
                        'status'         => 'Not Completed',
                        'id_user'       => auth()->user()->id,
                        'company_id'    => auth()->user()->company_id,
                    ]);
                }
            }
            DB::commit();
            return redirect()->back()->with('success-edit', 'Transaksi berhasil diubah.');
        } catch (\Throwable $th) {
             DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
