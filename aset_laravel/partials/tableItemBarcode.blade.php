@push('css')
    <style>
        table.dataTable td {
            white-space: nowrap; 
            vertical-align: middle;
        }
    </style>
@endpush
<div class="card">
    <div class="card-body p-4">
        <h5 class="mb-4">Data Barang BAPB | Barcode</h5>
        <div class="table-responsive">
            <table id="myTable2" class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th >No</th>
                        <th>Nama Barang & Spesifik Barang</th>
                        <th>Satuan</th>
                        <th>Jumlah</th>
                        <th>Barcode</th>
                        <th>Keterangan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barang_barcode as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>
                                {{ $item['product']['nama_barang'] ?? '' }}, {{ $item['nama_barang'] ?? '-' }}
                            </td>
                            <td>{{ $item['product']['satuan'] ?? '' }}</td>
                            <td>{{ $item['qty'] ?? '' }}</td>
                            <td>{{ $item['barcode'] ?? '' }}</td>
                            <td>{{ $item['keterangan'] ?? '' }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-warning" id="btn-edit-Barcode" title="Edit" data-bs-toggle="modal" data-bs-target="#editModalBarcode" data-id="{{ $item['id'] }}">
                                    Edit
                                </button>
                                <button type="button"  class="btn btn-sm btn-danger" title="Delete" id="btn-delete-barang-barcode" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $item['id'] }}">
                                        Hapus
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- edit modal --}}
<div class="modal fade" id="editModalBarcode" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content shadow-lg">
        <div class="modal-header bg-primary ">
        <h5 class="modal-title text-white" id="editBarcodeModalLabel">Edit Data Barang BAPB (Barcode)</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="editBarcodeForm" method="POST">
            @method('PUT')
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                        <label class="form-label">Barcode<span class="bintang" style="color: red;">*</span></label>
                        <input type="number" class="form-control" id="edit-barcode" name="barcode" placeholder="Jumlah" readonly>
                </div>
                <div class="mb-3">
                        <label class="form-label">Spesifik Barang<span class="bintang" style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="keterangan_barang-1" name="keterangan_barang" placeholder="Spesifik Barang" required>
                </div>
                <div class="mb-3">
                        <label class="form-label">Barang<span class="bintang" style="color: red;">*</span></label>
                        <select class="form-select" id="single-select-field-4" name="barang" required>
                            @foreach ($barang as $i)
                                <option value="{{ $i['id'] }}">{{ $i['nama_barang'] }}</option>
                            @endforeach
                        </select>
                </div>
                <div class="mb-3">
                        <label class="form-label">Quantity<span class="bintang" style="color: red;">*</span></label>
                        <input type="number" class="form-control" id="edit-qty-1" name="quantity" min="1" placeholder="Jumlah" readonly>
                </div>
                <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="keterangan-1" class="form-control" rows="3" placeholder="Keterangan"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info text-white">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
    </div>
</div>
 {{-- modal delete --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title text-white" id="deleteModalLabel">Delete Data Barang BAPB</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body text-center">
                <p class="fs-5 fw-semibold">Apakah anda yakin akan menghapus data tersebut?</p>
            </div>

            <form id="deleteBarangBarcode" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-danger px-4">Delete</button>
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://cdn.datatables.net/2.3.1/js/dataTables.js"></script>
<script>
    const urlEditBarcode = "{{ route('bapbbarang.edit', ':id') }}";
    const routeUpdateBarcode = "{{ route('bapbbarang.update', ':id') }}";
    const routeDeleteBapb = "{{ route('bapbbarang.destroy', ':id') }}";
    $(document).on('click', '#btn-edit-Barcode', function () {
        let id = $(this).data('id');
        const form = document.getElementById('editBarcodeForm');
        form.action = routeUpdateBarcode.replace(':id', id);
        let finalUrl = urlEditBarcode.replace(':id', id);
        form.reset();
        $('#single-select-field-4').val('').trigger('change');
        $('textarea[name="keterangan-1"]').val('');
        $.ajax({
            type: "GET",
            url: finalUrl,
            dataType: 'json',
            success: function (res) {
                if (res && res.barang_barcode) {
                    $('#edit-barcode').val(res.barang_barcode.barcode);
                    $('#keterangan_barang-1').val(res.barang_barcode.nama_barang);
                    $('#single-select-field-4').val(res.barang_barcode.id_barang).trigger('change');
                    $('#edit-qty-1').val(res.barang_barcode.qty);
                    $('textarea[name="keterangan-1"]').val(res.barang_barcode.keterangan ?? '');
                }
            },
            error: function () {
                alert('Gagal mengambil data barang. Silakan coba lagi.');
            }
        });
    });
    $(document).on('click', '#btn-delete-barang-barcode', function () {
        const id = $(this).data('id');
        const form = document.getElementById('deleteBarangBarcode');
        form.action = routeDeleteBapb.replace(':id', id);
    });
    $(document).ready(function () {
        $('#myTable2').DataTable();
    });
</script>
@endpush