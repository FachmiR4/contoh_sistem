@extends('layouts.app')
@section('title')
    Aplikasi Aset & Kendaraan | Edit Data Manajemen Pemakaian Kendaraan
@endsection

@push('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link href="{{ asset('layouts/assets/plugins/Drag-And-Drop/dist/imageuploadify.min.css') }}" rel="stylesheet">
<style>
    :root { --highlight: rgba(255,200,0,0.45); --hover: rgba(255,0,0,0.35); }
    body {
      font-family: Arial, sans-serif;
      text-align: center;
      margin: 20px;
      background:#fafafa;
    }
    .car-wrapper {
      display:inline-block;
      position:relative;
      max-width:100%;
      width:900px; /* adapt if needed */
      border-radius:8px;
      overflow:visible;
      box-shadow:0 6px 18px rgba(0,0,0,0.08);
      background:#fff;
    }

    /* base full car image */
    .car-base {
      display:block;
      width:100%;
      height:auto;
      user-select:none;
      -webkit-user-drag:none;
      border-radius:6px;
    }

    /* overlay container sits on top of image */
    .overlay {
      position:absolute;
      top:0; left:0; right:0; bottom:0;
      pointer-events:none; /* enable pointer only on buttons */
    }

    /* clickable part button */
    .part-btn {
      position:absolute;
      pointer-events:auto;
      border:0;
      background:var(--highlight);
      padding:0;
      width:64px;
      height:64px;
      display:flex;
      align-items:center;
      justify-content:center;
      border-radius:50%;
      cursor:pointer;
      transition:transform .12s ease, background .12s ease;
      box-shadow:0 4px 10px rgba(0,0,0,0.12);
    }
    .part-btn p {
        margin: 0;
        font-weight: 700;
        color: #222;
        user-select: none;
    }
    .part-btn img { width:60%; height:60%; object-fit:contain; pointer-events:none; user-select:none; }
    .part-btn:hover { transform:scale(1.08); background:var(--hover); }

    /* small label near clicked item */
    .info-box {
      margin-top:15px;
      padding:12px 16px;
      background:#fff;
      border-radius:6px;
      display:inline-block;
      min-width:220px;
      box-shadow:0 6px 18px rgba(0,0,0,0.06);
      text-align:left;
      display:none;
    }
    .info-box strong { display:block; margin-bottom:6px; }
    .hint { font-size:0.9rem; color:#666; margin-bottom:8px; }

    /* responsive: scale button size on small screens */
    @media (max-width:600px) {
      .car-wrapper { width:100%; }
      .part-btn { width:29px; height:26px; }
    }
    .fuel-gauge {
        width: 200px;
        height: 100px;
        position: relative;
        margin: 0 auto;
    }
    .arc {
        width: 100%;
        height: 100%;
        border-top-left-radius: 100px;
        border-top-right-radius: 100px;
        background: #fff;
        border: 4px solid #333;
        border-bottom: none;
        position: absolute;
        top: 0;
        left: 0;
    }
    .needle {
        width: 4px;
        height: 90px;
        background: red;
        position: absolute;
        bottom: 0;
        left: 50%;
        transform-origin: bottom center;
        transform: rotate(-90deg);
        transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 3;
    }
    .tick, .tick2 {
        width: 4px;
        height: 15px;
        background: #333;
        position: absolute;
        bottom: 0;
        left: 50%;
        transform-origin: bottom center;
    }
    .tick.red, .tick2.red2 {
        background: red;
    }
    .tick.green, .tick2.green2 {
        background: green;
    }
    .labels {
        display: flex;
        justify-content: space-between;
        width: 200px;
        margin: 10px auto 0 auto;
    }
    .labels span {
        font-weight: bold;
    }
    .part-btn.saved {
        background: #e0544f !important; /* merah untuk menunjukkan sudah disimpan */
    }
    label {
        font-weight: bold;
    }
    select {
        margin-bottom: 10px;
    }
</style>
@endpush

@section('breadcrumb')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center">
        <div class="breadcrumb-title pe-3">Tambah Manajemen Pemakaian Kendaraan</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ Route('home') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="">Data Pemakaian Kendaraan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Data Manajemen Pemakaian Kendaraan</li>
                </ol>
            </nav>
        </div>
    </div>
@endsection

@section('content-main')
<div class="card-body p-4">
    <h5 class="mb-4">Form Pengecekan Awal</h5>
    <form action="{{ Route('managementLending.store', $peminjaman->id) }}" method="POST" class="row g-3" enctype="multipart/form-data">
        @csrf
        <div class="col-md-6">
            <label class="form-label">Pengemudi</label>
            <input type="text" class="form-control" name="pengemudi" placeholder="Pengemudi" maxlength="11">
        </div>
        <div class="col-md-6">
            <label class="form-label">Kendaraan</label>
            <select class="form-select" name="kendaraan">
                <option selected disabled>Pilih Kendaraan</option>
                @foreach ($kendaraan as $item)
                    <option value="{{ $item->id }}">{{ $item->nopol }} - {{ $item->merk ?? '-' }} - {{ $item->jenis ?? '-' }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Kilo Meter Awal</label>
            <div class="input-group">
                <input type="number" name="kiloMeterAwal" class="form-control">
                <span class="input-group-text">Km</span>
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label">Tanggal Pengambilan</label>
            <input type="datetime-local" class="form-control" name="tanggalPengambilan">
        </div>
        
        <h3>Kondisi Kendaraan</h3>

        <div class="car-wrapper" id="carWrapper">
            <!-- gambar eksterior (default visible) -->
            <img src="{{ asset('layouts/assets/images/cover-full.png') }}" alt="Gambar Mobil - Exterior" class="car-base" id="carBaseExterior">

            <!-- gambar interior (tersimpan di DOM, hidden saat switch off) -->
            <img src="{{ asset('layouts/assets/images/interior.png') }}" alt="Gambar Mobil - Interior" class="car-base" id="carBaseInterior" style="display:none;">

            <!-- overlay untuk setiap gambar; masing-masing overlay berisi tombol part -->
            <div class="overlay" id="overlayExterior">
                <!-- BUTTON-TOMBOL BAGIAN MOBIL (eksterior) - jangan ubah posisi/tampilan -->
                <button type="button" class="part-btn" data-info="1. Spakbor Depan Kanan" data-id="1" style="top:69%; left:62%;"><p><strong>1</strong></p></button>
                <button type="button" class="part-btn" data-info="2. Pintu Depan Kanan" data-id="2" style="top:73%; left:51%;"><p><strong>2</strong></p></button>
                <button type="button" class="part-btn" data-info="3. Pintu Belakang Kanan" data-id="3" style="top:73%; left:40%;"><p><strong>3</strong></p></button>
                <button type="button" class="part-btn" data-info="4. Spakbor Belakang Kanan" data-id="4" style="top:72%; left:23%;"><p><strong>4</strong></p></button>
                <button type="button" class="part-btn" data-info="5. Ban Depan Kanan" data-id="5" style="top:79%; left:65%;"><p><strong>5</strong></p></button>
                <button type="button" class="part-btn" data-info="6. Ban Belakang Kanan" data-id="6" style="top:81%; left:30%;"><p><strong>6</strong></p></button>

                <button type="button" class="part-btn" data-info="7. Spakbor Depan Kiri" data-id="7" style="top:14%; left:60%;"><p><strong>7</strong></p></button>
                <button type="button" class="part-btn" data-info="8. Pintu Depan Kiri" data-id="8" style="top:12%; left:51%;"><p><strong>8</strong></p></button>
                <button type="button" class="part-btn" data-info="9. Pintu Belakang Kiri" data-id="9" style="top:10%; left:39%;"><p><strong>9</strong></p></button>
                <button type="button" class="part-btn" data-info="10. Spakbor Belakang Kiri" data-id="10" style="top:7%; left:23%;"><p><strong>10</strong></p></button>
                <button type="button" class="part-btn" data-info="11. Ban Depan Kiri" data-id="11" style="top:6%; left:65%;"><p><strong>11</strong></p></button>
                <button type="button" class="part-btn" data-info="12. Ban Belakang Kiri" data-id="12" style="top:1%; left:30%;"><p><strong>12</strong></p></button>

                <button type="button" class="part-btn" data-info="13. Kap Mesin" data-id="13" style="top:41%; left:64%;"><p><strong>13</strong></p></button>
                <button type="button" class="part-btn" data-info="14. Bemper Depan" data-id="14" style="top:44%; left:78%;"><p><strong>14</strong></p></button>
                <button type="button" class="part-btn" data-info="15. Kaca Depan" data-id="15" style="top:44%; left:54%;"><p><strong>15</strong></p></button>
                <button type="button" class="part-btn" data-info="16. Atap Mobil" data-id="16" style="top:42%; left:42%;"><p><strong>16</strong></p></button>
                <button type="button" class="part-btn" data-info="17. Tutup Bagasi" data-id="17" style="top:43%; left:22%;"><p><strong>17</strong></p></button>
                <button type="button" class="part-btn" data-info="18. Bemper Belakang" data-id="18" style="top:43%; left:10%;"><p><strong>18</strong></p></button>
                <button type="button" class="part-btn" data-info="19. Kaca Belakang" data-id="19" style="top:42%; left:31%;"><p><strong>19</strong></p></button>
            </div>

            <div class="overlay" id="overlayInterior" style="display:none;">
                <!-- BUTTON-TOMBOL BAGIAN MOBIL (interior) - data-id dimulai dari 20 (19 exterior) -->
                <button type="button" class="part-btn" data-info="Dashboard" data-id="20" style="top:53%; left:62%;"><p><strong>1</strong></p></button>
                <button type="button" class="part-btn" data-info="Sistem audio" data-id="21" style="top:72%; left:61%;"><p><strong>2</strong></p></button>
                <button type="button" class="part-btn" data-info="AC" data-id="22" style="top:41%; left:40%;"><p><strong>3</strong></p></button>
                <button type="button" class="part-btn" data-info="Jok" data-id="23" style="top:58%; left:48%;"><p><strong>4</strong></p></button>
                <button type="button" class="part-btn" data-info="Elektronik / Radio" data-id="24" style="top:40%; left:58%;"><p><strong>5</strong></p></button>
                <button type="button" class="part-btn" data-info="Setir" data-id="25" style="top:22%; left:56%;"><p><strong>6</strong></p></button>

                <button type="button" class="part-btn" data-info="Karpet" data-id="26" style="top:61%; left:38%;"><p><strong>7</strong></p></button>
                <button type="button" class="part-btn" data-info="Atap Interior" data-id="27" style="top:41%; left:31%;"><p><strong>8</strong></p></button>
                <button type="button" class="part-btn" data-info="Doortrim" data-id="28" style="top:7%; left:53%;"><p><strong>9</strong></p></button>
                <button type="button" class="part-btn" data-info="Sabuk Pengaman" data-id="29" style="top:12%; left:41%;"><p><strong>10</strong></p></button>
                <button type="button" class="part-btn" data-info="Sistem keselamatan" data-id="30" style="top:31%; left:76%;"><p><strong>11</strong></p></button>
                <button type="button" class="part-btn" data-info="Konsol Tengah" data-id="31" style="top:41%; left:50%;"><p><strong>12</strong></p></button>

                <button type="button" class="part-btn" data-info="Ban Serep" data-id="32" style="top:38%; left:10%;"><p><strong>13</strong></p></button>
                <button type="button" class="part-btn" data-info="Spion Interior" data-id="33" style="top:34%; left:65%;"><p><strong>14</strong></p></button>
                <button type="button" class="part-btn" data-info="Aki" data-id="34" style="top:19%; left:85%;"><p><strong>15</strong></p></button>
                <button type="button" class="part-btn" data-info="Klakson" data-id="35" style="top:42%; left:83%;"><p><strong>16</strong></p></button>
                <button type="button" class="part-btn" data-info="Kamera mundur / sensor parkir" data-id="36" style="top:39%; left:1%;"><p><strong>17</strong></p></button>
                <button type="button" class="part-btn" data-info="Spion Kanan" data-id="37" style="top:88%; left:61%;"><p><strong>18</strong></p></button>
                <button type="button" class="part-btn" data-info="Spion Kiri" data-id="38" style="top:0%; left:62%;"><p><strong>19</strong></p></button>
            </div>
        </div>

        <br>

         <!-- TABEL KONDISI KENDARAAN: rapih & terstruktur -->
        <div class="col-12">
            @php
                $bagianExterior = [
                    '1. Spakbor Depan Kanan', '2. Pintu Depan Kanan', '3. Pintu Belakang Kanan', '4. Spakbor Belakang Kanan',
                    '5. Ban Belakang Kanan', '6. Ban Depan Kanan',
                    '7. Spakbor Depan Kiri', '8. Pintu Depan Kiri', '9. Pintu Belakang Kiri', '10. Spakbor Belakang Kiri',
                    '11. Ban Belakang Kiri', '12. Ban Depan Kiri',
                    '13. Kap Mesin', '14. Bemper Depan', '15. Kaca Depan', '16. Atap Mobil',
                    '17. Tutup Bagasi', '18. Bemper Belakang', '19. Kaca Belakang'
                ];

                $bagianInterior = [
                    '1. Dashboard', '2. Sistem audio', '3. AC', '4. Jok', '5. Elektronik / Radio', '6. Setir', 
                    '7. karpet', '8. Atap Interior', '9. Doortrim', '10. Sabuk Pengaman', '11. Sistem Keselamatan', 
                    '12. Konsol Tengah', '13. Ban Serep', '14. Spion Interior', '15. Aki', '16. Klakson', '17. Kamera Mundur / Sensor Parkir',
                    '18. Spion Kanan', '19. Spion Kiri' 
                ];

                $startInteriorIndex = count($bagianExterior); // ensures unique data-id across both tables
            @endphp

            <div class="row g-3">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header bg-light">
                            <strong>Bagian Exterior</strong>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-bordered table-sm mb-0" id="fullTableExterior">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>Bagian</th>
                                        <th class="text-center">Baik</th>
                                        <th class="text-center">Penyok</th>
                                        <th class="text-center">Gores</th>
                                        <th class="text-center">Pecah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bagianExterior as $index => $bagian)
                                        @php $idx = $index; @endphp
                                        <tr id="row-ex-{{ $idx }}">
                                            <td class="align-middle">{{ $bagian }}</td>
                                            @foreach(['Baik', 'Penyok', 'Gores', 'Pecah'] as $kondisi)
                                                <td class="text-center align-middle">
                                                    <input type="radio"
                                                        class="cb-kondisi"
                                                        data-id="{{ $idx }}"
                                                        value="{{ $kondisi }}"
                                                        name="kondisi_eksterior[{{ $idx }}][kategori]"
                                                         {{ $kondisi == 'Baik' ? 'checked' : '' }}>
                                                </td>
                                            @endforeach
                                            <input type="hidden" name="kondisi_eksterior[{{ $idx }}][bagian]" value="{{ $bagian }}">
                                            {{-- hidden input untuk tgl kejadian --}}
                                            <input type="hidden" name="kondisi_eksterior[{{ $idx }}][tgl_kejadian]" value="" class="tgl-kejadian-eksterior">
                                            {{-- hidden input untuk file names --}}
                                            <input type="hidden" name="kondisi_eksterior[{{ $idx }}][file_names]" value="" class="file-names-eksterior">
                                            {{-- hidden input file --}}
                                            <input type="file" name="files[{{ $idx }}][]" multiple style="display:none" id="files-{{ $idx }}">
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header bg-light d-flex align-items-center justify-content-between">
                            
                            <!-- Tulisan di kiri -->
                            <strong class="mb-0">Bagian Interior</strong>

                            <!-- Toggle di kanan -->
                            <div class="form-check form-switch form-check-success mb-0">
                                <input class="form-check-input" type="checkbox" role="switch" id="toggleInterior">
                                <label class="form-check-label ms-2 mb-0" for="toggleInterior">
                                    <strong>Tampilkan Interior</strong>
                                </label>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-bordered table-sm mb-0" id="fullTableInterior">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>Bagian</th>
                                        <th class="text-center">Baik</th>
                                        <th class="text-center">Rusak</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bagianInterior as $index => $bagian)
                                        @php $idx = $startInteriorIndex + $index; @endphp
                                        <tr id="row-in-{{ $idx }}">
                                            <td class="align-middle">{{ $bagian }}</td>
                                            @foreach(['Baik', 'Rusak'] as $kondisi)
                                                <td class="text-center align-middle">
                                                    <input type="radio"
                                                        class="cb-kondisi"
                                                        data-id="{{ $idx }}"
                                                        value="{{ $kondisi }}"
                                                        name="kondisi_interior[{{ $idx }}][kategori]"
                                                        {{ $kondisi == 'Baik' ? 'checked' : '' }}>
                                                </td>
                                            @endforeach
                                            <input type="hidden" name="kondisi_interior[{{ $idx }}][bagian]" value="{{ $bagian }}">
                                            {{-- hidden input untuk tgl kejadian --}}
                                            <input type="hidden" name="kondisi_interior[{{ $idx }}][tgl_kejadian]" value="" class="tgl-kejadian-interior">
                                            {{-- hidden input untuk file names --}}
                                            <input type="hidden" name="kondisi_interior[{{ $idx }}][file_names]" value="" class="file-names-interior">
                                            {{-- hidden input file --}}
                                            <input type="file" name="files[{{ $idx }}][]" multiple style="display:none" id="files-{{ $idx }}">
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 
        </div> 
        <div class="col-md-12">
            <div class="d-md-flex d-grid align-items-center gap-3">
                <button type="submit" class="btn btn-success px-4 text-white" id="submitBtn">Update Data</button>
                <a href="{{ Route('managementLending.index') }}" class="btn btn-danger px-4 text-white">Kembali</a>
            </div>
        </div>
    </form>
</div>
@endsection
@push('scripts')
    <script src="{{ asset('layouts/assets/plugins/Drag-And-Drop/dist/imageuploadify.min.js') }}"></script>
    <script>
        // Initialize imageuploadify on the main input (preview area)
        $(document).ready(function () {
            // initialize plugin on the main input (if plugin loaded and element exists)
            if (typeof $ !== 'undefined' && $.fn && $.fn.imageuploadify) {
                try {
                    if ($('#image-uploadify-main').length) {
                        $('#image-uploadify-main').imageuploadify();
                    }
                } catch (e) {
                    console.warn('imageuploadify init failed', e);
                }
            }
        });

        document.addEventListener("DOMContentLoaded", () => {

            let kondisiSaved = {}; // penyimpan semua nilai kondisi
            // select rows from both exterior & interior tables (keeps compatibility)
            const rows = document.querySelectorAll("#fullTableExterior tbody tr, #fullTableInterior tbody tr");

            // --- Inisialisasi kondisiSaved ---
            document.querySelectorAll(".cb-kondisi").forEach(cb => {
                const id = cb.dataset.id;
                if (!kondisiSaved[id]) kondisiSaved[id] = null;
            });

            // Mencegah perubahan pada radio (readonly)
            document.querySelectorAll('.cb-kondisi').forEach(radio => {
                radio.addEventListener('click', function(e) {
                    e.preventDefault();
                });
            });

            // Saat radio berubah → update memory (meskipun dicegah, untuk konsistensi)
            document.querySelectorAll(".cb-kondisi").forEach(cb => {
                cb.addEventListener("change", function () {
                    const id = this.dataset.id;
                    if (this.checked) {
                        kondisiSaved[id] = this.value;
                    }
                });
            });
            const toggle = document.getElementById('toggleInterior');
            const exteriorImg = document.getElementById('carBaseExterior');
            const interiorImg = document.getElementById('carBaseInterior');
            const overlayEx = document.getElementById('overlayExterior');
            const overlayIn = document.getElementById('overlayInterior');

            // toggle handler: when checked -> show interior, hide exterior
            if (toggle) {
                toggle.addEventListener('change', function () {
                    if (this.checked) {
                        exteriorImg.style.display = 'none';
                        overlayEx.style.display = 'none';
                        interiorImg.style.display = '';
                        overlayIn.style.display = '';
                    } else {
                        exteriorImg.style.display = '';
                        overlayEx.style.display = '';
                        interiorImg.style.display = 'none';
                        overlayIn.style.display = 'none';
                    }
                });
            }

            // ensure initial state (switch off = exterior visible)
            if (toggle && !toggle.checked) {
                exteriorImg.style.display = '';
                overlayEx.style.display = '';
                interiorImg.style.display = 'none';
                overlayIn.style.display = 'none';
            }

            // --- Klik sekali/two-click pada part-btn ---
            const partButtons = document.querySelectorAll(".part-btn");
            const CLICK_DELAY = 250; // ms

            // helper: find row by index (tries exterior, interior, legacy)
            function findRowByIndex(index) {
                return document.getElementById(`row-ex-${index}`) ||
                       document.getElementById(`row-in-${index}`) ||
                       document.getElementById(`row-${index}`);
            }

           function showModal(index) {
                    // detect row type
                    const rowEx = document.getElementById(`row-ex-${index}`);
                    const rowIn = document.getElementById(`row-in-${index}`);
                    const rowLegacy = document.getElementById(`row-${index}`);
                    const row = rowEx || rowIn || rowLegacy;
                    if (!row) return;

                    const bagianText = row.querySelector('td:first-child')?.textContent || 'Bagian';
                    // whether this is exterior or interior
                    const isExterior = !!rowEx;
                    const isInterior = !!rowIn;

                    // current selection (if any) from table
                    const currentSelected = row.querySelector('.cb-kondisi:checked')?.value || null;

                    // get current tanggal kejadian from hidden input
                    const tglInput = row.querySelector('input[name*="tgl_kejadian"]');
                    const tglValue = tglInput ? tglInput.value : '';

                    // unique modal file input id
                    const modalInputId = `image-uploadify-modal-${index}`;

                    // build modal header
                    let modalContent = `
                        <div class="modal fade" id="kondisiModal${index}" tabindex="-1" aria-labelledby="kondisiModalLabel${index}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered ">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title text-white" id="kondisiModalLabel${index}">
                                            <i class="bi bi-car-front me-2"></i>${bagianText}
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row g-3">
                    `;

                    if (isExterior) {
                        // exterior: only show Penyok, Gores, Pecah (no "Baik" in modal)
                        const options = ['Penyok','Gores','Pecah'];
                        options.forEach((kondisi, idx) => {
                            const uniqueId = `kondisi_${index}_${idx}`;
                            const isChecked = currentSelected === kondisi ? 'checked' : '';
                            modalContent += `
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input kondisi-radio" type="radio" id="${uniqueId}"
                                            name="modal_kondisi_${index}"
                                            data-id="${index}"
                                            data-kondisi="${kondisi}"
                                            ${isChecked}>
                                        <label class="form-check-label" for="${uniqueId}">
                                            <strong>${kondisi}</strong>
                                        </label>
                                    </div>
                                </div>
                            `;
                        });
                    } else if (isInterior) {
                        // interior: no radio inputs; show a simple checkbox to mark Rusak
                        // initialize checked state from table radio 'Rusak' if present
                        const isRusak = row.querySelector('.cb-kondisi[value="Rusak"]')?.checked ? 'checked' : '';
                        modalContent += `
                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="rusak_${index}" ${isRusak}>
                                    <label class="form-check-label" for="rusak_${index}"><strong>Sudah Rusak</strong></label>
                                </div>
                            </div>
                        `;
                    } else {
                        // fallback: show full radio set
                        const fallbacks = ['Baik','Penyok','Gores','Pecah'];
                        fallbacks.forEach((kondisi, idx) => {
                            const uniqueId = `kondisi_${index}_${idx}`;
                            const isChecked = currentSelected === kondisi ? 'checked' : '';
                            modalContent += `
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input kondisi-radio" type="radio" id="${uniqueId}"
                                            name="modal_kondisi_${index}"
                                            data-id="${index}"
                                            data-kondisi="${kondisi}"
                                            ${isChecked}>
                                        <label class="form-check-label" for="${uniqueId}">
                                            <strong>${kondisi}</strong>
                                        </label>
                                    </div>
                                </div>
                            `;
                        });
                    }

                    // common fields: date & file upload
                    modalContent += `
                                        <div class="col-12">
                                            <label class="form-label">Tanggal Kejadian</label>
                                            <input type="date" class="form-control" name="tanggalKejadian_${index}" value="${tglValue}">
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Upload Files</label>
                                            <div class="card">
                                                <div class="card-body">
                                                    <input id="${modalInputId}" name="modal_files_${index}[]" type="file" accept=".jpeg, .png, .jpg" multiple>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <button type="button" class="btn btn-primary" onclick="saveKondisi(${index}, this)">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    `;

                    // remove old modal if present
                    const oldModal = document.getElementById(`kondisiModal${index}`);
                    if (oldModal) oldModal.remove();

                    // append new modal
                    document.body.insertAdjacentHTML('beforeend', modalContent);

                    // show modal
                    const modalEl = document.getElementById(`kondisiModal${index}`);
                    const modal = new bootstrap.Modal(modalEl);
                    modal.show();

                    // init imageuploadify for modal file input (if available)
                    if (typeof $ !== 'undefined' && $.fn && $.fn.imageuploadify) {
                        try {
                            $(`#${modalInputId}`).imageuploadify();
                        } catch (e) {
                            console.warn('imageuploadify init failed on modal input', e);
                        }
                    }

                    // wiring: exterior radio choices -> update main table radios
                    if (isExterior) {
                        document.querySelectorAll(`#kondisiModal${index} .kondisi-radio`).forEach(radio => {
                            radio.addEventListener('change', function() {
                                const kondisi = this.getAttribute('data-kondisi');
                                const dataId = this.getAttribute('data-id');

                                // unset table radios for this row, then set matching one
                                document.querySelectorAll(`.cb-kondisi[data-id="${dataId}"]`).forEach(r => r.checked = false);
                                const mainRadio = document.querySelector(`.cb-kondisi[data-id="${dataId}"][value="${kondisi}"]`);
                                if (mainRadio) {
                                    mainRadio.checked = true;
                                    mainRadio.dispatchEvent(new Event('change'));
                                } else {
                                    // if table radio not found, create hidden field for exterior kategori
                                    let hid = document.querySelector(`input[name="kondisi_eksterior[${dataId}][kategori]"]`);
                                    if (!hid) {
                                        hid = document.createElement('input');
                                        hid.type = 'hidden';
                                        hid.name = `kondisi_eksterior[${dataId}][kategori]`;
                                        document.querySelector('form').appendChild(hid);
                                    }
                                    hid.value = kondisi;
                                }
                            });
                        });
                    }

                    // wiring: interior checkbox -> update/create hidden nilai 'Rusak' / 'Baik'
                    if (isInterior) {
                        const chk = document.getElementById(`rusak_${index}`);
                        const mainRusak = document.querySelector(`.cb-kondisi[data-id="${index}"][value="Rusak"]`);
                        const mainBaik = document.querySelector(`.cb-kondisi[data-id="${index}"][value="Baik"]`);
                        // ensure hidden input exists
                        function ensureHiddenInterior() {
                            let hidden = document.querySelector(`input[name="kondisi_interior[${index}][kategori]"]`);
                            if (!hidden) {
                                hidden = document.createElement('input');
                                hidden.type = 'hidden';
                                hidden.name = `kondisi_interior[${index}][kategori]`;
                                document.querySelector('form').appendChild(hidden);
                            }
                            return hidden;
                        }
                        const hiddenInput = ensureHiddenInterior();

                        if (chk) {
                            // initial sync: set checkbox according to main radio
                            chk.checked = !!(mainRusak && mainRusak.checked);
                            hiddenInput.value = chk.checked ? 'Rusak' : (mainBaik && mainBaik.checked ? 'Baik' : hiddenInput.value || 'Baik');

                            // when checkbox toggled => update main radios and hidden
                            chk.addEventListener('change', function () {
                                if (this.checked) {
                                    if (mainRusak) { mainRusak.checked = true; mainRusak.dispatchEvent(new Event('change')); }
                                    hiddenInput.value = 'Rusak';
                                } else {
                                    if (mainBaik) { mainBaik.checked = true; mainBaik.dispatchEvent(new Event('change')); }
                                    hiddenInput.value = 'Baik';
                                }
                            });

                            // keep checkbox in sync if user clicks main radios while modal open
                            [mainRusak, mainBaik].forEach(r => {
                                if (!r) return;
                                r.addEventListener('change', function () {
                                    // update checkbox to reflect whether 'Rusak' is selected
                                    chk.checked = !!(mainRusak && mainRusak.checked);
                                    hiddenInput.value = chk.checked ? 'Rusak' : (mainBaik && mainBaik.checked ? 'Baik' : hiddenInput.value || 'Baik');
                                });
                            });
                        }
                    }
                }

            // untuk mencegah click setelah touch pada beberapa device
            let lastTouchTime = 0;

            function handleSingle(idx) {
                showModal(idx);
            }

            function handleDouble(idx) {
                showModal(idx);
            }

            partButtons.forEach(btn => {
                // tap-count logic that works for touch and mouse
                btn._tapCount = 0;
                btn._tapTimer = null;

                function registerTap(isTouch) {
                    if (isTouch) lastTouchTime = Date.now();
                    btn._tapCount++;
                    if (btn._tapTimer) clearTimeout(btn._tapTimer);
                    btn._tapTimer = setTimeout(() => {
                        if (btn._tapCount === 1) {
                            const idx = parseInt(btn.dataset.id) - 1;
                            handleSingle(idx);
                        } else if (btn._tapCount >= 2) {
                            const idx = parseInt(btn.dataset.id) - 1;
                            handleDouble(idx);
                        }
                        btn._tapCount = 0;
                    }, CLICK_DELAY);
                }

                // touchend for mobile
                btn.addEventListener('touchend', function (e) {
                    e.preventDefault();
                    registerTap(true);
                }, { passive: false });

                // click for mouse (ignore clicks immediately after touch)
                btn.addEventListener('click', function (e) {
                    const now = Date.now();
                    if (now - lastTouchTime < 700) {
                        return;
                    }
                    e.preventDefault();
                    registerTap(false);
                });

                // keyboard accessibility
                btn.addEventListener('keydown', function (e) {
                    if (e.key === "Enter" || e.key === " ") {
                        e.preventDefault();
                        registerTap(false);
                    }
                });
            });
        });

        // Helper: append files to the appropriate input based on index
        function appendFilesToBagian(index, fileList) {
            const isExterior = index < 19;
            const inputId = isExterior ? 'files-eksterior' : 'files-interior';
            const input = document.getElementById(inputId);
            if (!input) return;
            const dt = new DataTransfer();

            // keep existing files
            if (input.files && input.files.length) {
                Array.from(input.files).forEach(f => dt.items.add(f));
            }
            // add new files (avoid duplicates by name+size)
            fileList.forEach(f => {
                const exists = Array.from(dt.files).some(existing => existing.name === f.name && existing.size === f.size);
                if (!exists) dt.items.add(f);
            });

            input.files = dt.files;
        }

        // Helper: menyimpan files ke window.storedFiles
        function storeFilesForBagian(index, fileList) {
            window.storedFiles[index] = fileList;
            console.log(`Files stored for index ${index}:`, fileList);
        }

        // Helper: update input file dengan files
        function updateFileInput(index, fileList) {
            const fileInput = document.getElementById(`files-${index}`);
            if (fileInput) {
                const dt = new DataTransfer();
                fileList.forEach(f => dt.items.add(f));
                fileInput.files = dt.files;
                console.log(`Updated file input for index ${index} with ${fileList.length} files`);
            }
        }

        // global function untuk simpan kondisi
       function saveKondisi(index, btn) {
    const modalEl = document.getElementById(`kondisiModal${index}`);
    if (!modalEl) return;

    // =====================================================================
    // 1. Simpan FILES dari modal (MENYIMPAN SEMENTARA)
    // =====================================================================
    const modalInput = modalEl.querySelector(`#image-uploadify-modal-${index}`);
    if (modalInput && modalInput.files && modalInput.files.length) {
        const files = Array.from(modalInput.files);
        // simpan files ke window.storedFiles
        storeFilesForBagian(index, files);
        // update input file
        updateFileInput(index, files);
        console.log(`Files untuk index ${index}:`, files.map(f => f.name));

        // Update hidden field dengan nama file
        const isExterior = index < 19;
        const classToUpdate = isExterior ? 'file-names-eksterior' : 'file-names-interior';
        const hiddenInputs = document.querySelectorAll(`input[type="hidden"][class="${classToUpdate}"]`);
        hiddenInputs.forEach(input => {
            if (input.name.includes(`[${index}]`)) {
                input.value = files.map(f => f.name).join('|');
            }
        });
    } else {
        // Jika tidak ada file, kosongkan file names
        const isExterior = index < 19;
        const classToUpdate = isExterior ? 'file-names-eksterior' : 'file-names-interior';
        const hiddenInputs = document.querySelectorAll(`input[type="hidden"][class="${classToUpdate}"]`);
        hiddenInputs.forEach(input => {
            if (input.name.includes(`[${index}]`)) {
                input.value = '';
            }
        });
    }

    // =====================================================================
    // 2. Simpan kondisi (radio atau checkbox)
    // =====================================================================

    // ---- Exterior: radio button ----
    const selectedModalRadio = modalEl.querySelector('.kondisi-radio:checked');
    if (selectedModalRadio) {
        const kondisi = selectedModalRadio.getAttribute('data-kondisi');
        const dataId = selectedModalRadio.getAttribute('data-id');

        // sync ke tabel utama jika ada
        const mainRadio = document.querySelector(`.cb-kondisi[data-id="${dataId}"][value="${kondisi}"]`);
        if (mainRadio) {
            mainRadio.checked = true;
            mainRadio.dispatchEvent(new Event('change'));
        }
    }

    // ---- Interior: checkbox rusak/baik ----
    const rusakCheckbox = modalEl.querySelector(`#rusak_${index}`);
    if (rusakCheckbox) {
        // sync ke tabel utama
        const mainRusak = document.querySelector(`.cb-kondisi[data-id="${index}"][value="Rusak"]`);
        const mainBaik = document.querySelector(`.cb-kondisi[data-id="${index}"][value="Baik"]`);
        if (rusakCheckbox.checked) {
            if (mainRusak) { mainRusak.checked = true; mainRusak.dispatchEvent(new Event('change')); }
        } else {
            if (mainBaik) { mainBaik.checked = true; mainBaik.dispatchEvent(new Event('change')); }
        }
    }

    // =====================================================================
    // 3. Simpan tanggal kejadian ke hidden input (AGAR TERKIRIM KE CONTROLLER)
    // =====================================================================
    const dateInput = modalEl.querySelector('input[type="date"]');
    if (dateInput) {
        const dateVal = dateInput.value || "";
        // Update hidden input yang sudah ada di tabel
        const isExterior = index < 19;
        const hiddenName = isExterior ? `kondisi_eksterior[${index}][tgl_kejadian]` : `kondisi_interior[${index}][tgl_kejadian]`;
        const hidDate = document.querySelector(`input[name="${hiddenName}"]`);
        if (hidDate) {
            hidDate.value = dateVal;
            console.log(`Tanggal kejadian untuk index ${index}: ${dateVal}`);
        }
    }

    // =====================================================================
    // 4. Tutup modal + destroy + hapus DOM + update tombol
    // =====================================================================
    const modalInstance = bootstrap.Modal.getInstance(modalEl);
    if (modalInstance) modalInstance.hide();

    if (modalInput && typeof $ !== 'undefined' && $.fn && $.fn.imageuploadify) {
        try {
            $(`#image-uploadify-modal-${index}`).imageuploadify('destroy');
        } catch (e) {}
    }

    setTimeout(() => {
        const el = document.getElementById(`kondisiModal${index}`);
        if (el) el.remove();
    }, 250);

    // Tambahkan class 'saved' pada tombol untuk menunjukkan sudah disimpan
    const partBtn = document.querySelector(`.part-btn[data-id="${index + 1}"]`);
    if (partBtn) {
        partBtn.classList.add('saved');
    }
}

        // Storage untuk menyimpan files dari modal
        window.storedFiles = {};

        // Handle form submission dengan FormData untuk mengirim files
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();

            // Buat FormData dari form
            const formData = new FormData(this);

            // Submit menggunakan fetch
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => {
                if (response.ok) {
                    // Success - bisa redirect atau tampilkan pesan
                    console.log('Form submitted successfully');
                    window.location.href = '{{ Route("managementLending.index") }}';
                } else {
                    alert('Terjadi kesalahan saat mengirim data');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan: ' + error.message);
            });
        });
    </script>
@endpush
