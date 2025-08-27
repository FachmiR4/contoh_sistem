
    <div class="modal fade" id="tambahHistoryModal" tabindex="-1" aria-labelledby="tambahHistoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content shadow-lg">
            <div class="modal-header">
            <h5 class="modal-title" id="tambahHistoryModalLabel">Tambah Monitoring Aset</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ Route("stockopname.store") }}" method="POST" id="formTambah" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="hidden" name="id_aset" value="{{ $id }}" required>
                        <label class="form-label">Pengguna<span class="bintang" style="color: red;">*</span></label>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect01"><i class="fadeIn animated bx bx-user"></i></i></label>
                            <select name="pggn" class="form-select"  id="single-select-field" data-placeholder="Choose one thing">
                                <option selected disabled>Pilih Pengguna</option>
                                @foreach ($dataEmployees as $karyawan)
                                    <option value="{{ $karyawan['id'] }}">{{ $karyawan['nama'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lokasi Utama<span class="bintang" style="color: red;">*</span></label>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect02"><i class="fadeIn animated bx bx-buildings"></i></label>
                            <select  name="mainlks" class="form-select"  id="single-select-field-3" data-placeholder="Choose one thing">
                                <option selected disabled>Pilih Lokasi Utama</option>
                                @foreach ($dataMainLocations as $main)
                                    <option value="{{ $main['id'] }}">
                                        {{ $main['keterangan'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lokasi<span class="bintang" style="color: red;">*</span></label>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect03"><i class="lni lni-map-marker"></i></label>
                            <select  name="lks" class="form-select"  id="single-select-field-4" data-placeholder="Choose one thing" required>
                                <option selected disabled>Pilih Lokasi</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="ruangan" class="form-label">Ruangan<span class="bintang" style="color: red;">*</span></label>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect04"><i class="fadeIn animated bx bx-been-here"></i></label>
                            <select name="rng" class="form-select"  id="single-select-field-5" data-placeholder="Choose one thing" required>
                                <option selected disabled>Pilih Ruangan</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kondisi<span class="bintang" style="color: red;">*</span></label>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect05"><i class="fadeIn animated bx bx-message-alt-check"></i></label>
                            <select  name="sts" class="form-select" required>
                                <option selected disabled>Pilih Status</option>
                                @foreach ($dataConditions as $kondisi)
                                    <option value="{{ $kondisi['id'] }}">{{ $kondisi['kondisi'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Monitoring<span class="bintang" style="color: red;">*</span></label>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect05"><i class="fadeIn animated bx bx-calendar"></i></label>
                            <input type="date" class="form-control" name="tgl_pengadaan" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="formFileLg" class="form-label">Masukan Gambar</label>
						<input class="form-control" id="formFileLg" type="file" name="image" accept=".jpg, .png, image/jpeg, image/png">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Catatan</label>
                        <textarea class="form-control" id="keterangan" name="deskripsi" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info text-white">Tambahkan</button>
                    <button type="button" class="btn btn-danger px-4 text-white" onclick="resetForm()">Reset</button>
                </div>
            </form>
        </div>
        </div>
    </div>
    {{-- edit modal --}}
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content shadow-lg">
            <div class="modal-header bg-primary ">
            <h5 class="modal-title text-white" id="tambahHistoryModalLabel">Edit Data Stock Opname</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editHistoryForm" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="hidden" name="id_aset" value="{{ $id }}" required>
                        <label class="form-label">Pengguna<span class="bintang" style="color: red;">*</span></label>
                        <select name="edit-pggn" class="form-select"  id="single-select-field-6" data-placeholder="Choose one thing">
                            <option selected disabled>Pilih Pengguna</option>
                            @foreach ($dataEmployees as $karyawan)
                                <option value="{{ $karyawan['id'] }}">{{ $karyawan['nama'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lokasi Utama<span class="bintang" style="color: red;">*</span></label>
                        <select  name="mainlks" class="form-select"  id="single-select-field-10" data-placeholder="Choose one thing">
                            <option selected disabled>Pilih Lokasi Utama</option>
                            @foreach ($dataMainLocations as $main)
                                <option value="{{ $main['id'] }}">
                                    {{ $main['keterangan'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lokasi<span class="bintang" style="color: red;">*</span></label>
                        <select  name="edit-lks" class="form-select"  id="single-select-field-8" data-placeholder="Choose one thing">
                            <option selected disabled>Pilih Lokasi</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ruangan<span class="bintang" style="color: red;">*</span></label>
                        <select  name="edit-rng" class="form-select"  id="single-select-field-9" data-placeholder="Choose one thing">
                            <option selected disabled>Pilih Ruangan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kondisi<span class="bintang" style="color: red;">*</span></label>
                        <select  name="edit-sts" class="form-select">
                            <option selected disabled>Pilih Status</option>
                            @foreach ($dataConditions as $kondisi)
                                <option value="{{ $kondisi['id'] }}">{{ $kondisi['kondisi'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Monitoring<span class="bintang" style="color: red;">*</span></label>
                        <input type="date" class="form-control" name="edit-tgl_pengadaan" required>
                    </div>
                    <div class="mb-3">
                        <label for="formFileLg" class="form-label">Masukan Gambar</label>
						<input class="form-control" id="formFileLg2" type="file" name="image" accept=".jpg, .png, image/jpeg, image/png">
                    </div>
                    
                    <div class="mb-3">
                        <label for="" class="form-label">Catatan</label>
                        <textarea class="form-control" id="keterangan" name="edit-deskripsi" rows="3"></textarea>
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
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Data Aset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-primary" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" href="#primaryhome" role="tab" aria-selected="true">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><i class="bi bi-person me-1 fs-6"></i>
                                        </div>
                                        <div class="tab-title">Pengguna</div>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#primaryprofile" role="tab" aria-selected="false">
                                    <div class="d-flex align-items-center">
                                        <div class="tab-icon"><i class="bx bx-location-plus me-1 fs-6"></i>
                                        </div>
                                        <div class="tab-title">Lokasi</div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content py-3">
                            <div class="tab-pane fade show active" id="primaryhome" role="tabpanel">
                                    <div class="card-body p-4">
                                        <h5 class="mb-4 text-primary">Pengguna Saat ini</h5>
                                        <table class="data-aset">
                                            <tr>
                                                <td class="modal-detail">Nama Pengguna</td>
                                                <td>: {{ $dataEmployee[0]['nama'] ?? '' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="modal-detail">Pengguna Detail</td>
                                                <td>: {{ $dataAset['nama_pemakai2'] }}</td>
                                            </tr>
                                            <tr>
                                                <td class="modal-detail">Divisi</td>
                                                <td>: {{ $dataDivision[0]['name'] ?? '' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                            </div>
                            <div class="tab-pane fade" id="primaryprofile" role="tabpanel">
                                <div class="card-body p-4">
                                    <h5 class="mb-4 text-primary">Lokasi Saat ini</h5>
                                    <table class="data-aset">
                                        <tr>
                                            <td class="modal-detail">Lokasi Utama</td>
                                            <td>: {{ $dataLokasiUtama[0]['keterangan'] ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="modal-detail">Sub Lokasi</td>
                                            <td>: {{ $dataLocation[0]['keterangan'] ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="modal-detail">Ruangan</td>
                                            <td>: {{ $dataRoom[0]['deskripsi'] ?? '' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Delete modal --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title text-white" id="deleteModalLabel">Delete Data Stock</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body text-center">
                    <p class="fs-5 fw-semibold">Apakah anda yakin akan menghapus data tersebut?</p>
                </div>

                <form id="deleteHistoryForm" method="POST">
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
    <script>
        const routeGetLokasi = "{{ route('lokasi.get', ':id') }}";
        const routeGetRuangan = "{{ route('room.get', ':id') }}";
        // handle select option lokasi
        $(document).ready(function() {
            $('#single-select-field-3').change(function() {
                var lokasiId = $(this).val();
                var LokasiSelect = $('#single-select-field-4');
                if (lokasiId) {
                    $.ajax({
                        url: routeGetLokasi.replace(':id', lokasiId),
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            LokasiSelect.empty();
                            LokasiSelect.append('<option value="">Pilih Sub Lokasi</option>');
                            $.each(data, function(index, dataLocation) {
                                LokasiSelect.append('<option value="' + dataLocation.id + '">' + dataLocation.keterangan + '</option>');
                            });
                        }
                    });
                } else {
                    LokasiSelect.empty().append('<option value="">Pilih Sub Lokasi</option>');
                }
            });
        });
        // handle select option ruangan
        $(document).ready(function() {
            $('#single-select-field-4').change(function() {
                var ruanganId = $(this).val();
                var RuanganSelect = $('#single-select-field-5');
                if (ruanganId) {
                    $.ajax({
                        url: routeGetRuangan.replace(':id', ruanganId),
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            console.log(ruanganId,data);
                            RuanganSelect.empty();
                            RuanganSelect.append('<option value="">Pilih Sub Lokasi</option>');
                            $.each(data, function(index, dataRoom) {
                                RuanganSelect.append('<option value="' + dataRoom.id + '">' + dataRoom.deskripsi + '</option>');
                            });
                        }
                    });
                } else {
                    RuanganSelect.empty().append('<option value="">Pilih Sub Lokasi</option>');
                }
            });
        });
         // handle select option lokasi-edit
        $(document).ready(function() {
            $('#single-select-field-10').change(function() {
                var lokasiId = $(this).val();
                var LokasiSelect = $('#single-select-field-8');
                if (lokasiId) {
                    $.ajax({
                        url: routeGetLokasi.replace(':id', lokasiId),
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            LokasiSelect.empty();
                            LokasiSelect.append('<option value="">Pilih Sub Lokasi</option>');
                            $.each(data, function(index, dataLocation) {
                                LokasiSelect.append('<option value="' + dataLocation.id + '">' + dataLocation.keterangan + '</option>');
                            });
                        }
                    });
                } else {
                    LokasiSelect.empty().append('<option value="">Pilih Sub Lokasi</option>');
                }
            });
        });
        // handle select option ruangan-edit
        $(document).ready(function() {
            $('#single-select-field-8').change(function() {
                var ruanganId = $(this).val();
                var RuanganSelect = $('#single-select-field-9');
                if (ruanganId) {
                    $.ajax({
                        url: routeGetRuangan.replace(':id', ruanganId),
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            console.log(ruanganId,data);
                            RuanganSelect.empty();
                            RuanganSelect.append('<option value="">Pilih Sub Lokasi</option>');
                            $.each(data, function(index, dataRoom) {
                                RuanganSelect.append('<option value="' + dataRoom.id + '">' + dataRoom.deskripsi + '</option>');
                            });
                        }
                    });
                } else {
                    RuanganSelect.empty().append('<option value="">Pilih Sub Lokasi</option>');
                }
            });
        });

    </script>
@endpush