{{-- tambah modal monitoring --}}
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
                            <select  name="lks" class="form-select lokasi-input"  id="single-select-field-4" data-placeholder="Choose one thing" required>
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
                    <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect01"><i class="fadeIn animated bx bx-user"></i></i></label>
                            <select name="edit-pggn" class="form-select"  id="single-select-field-6" data-placeholder="Choose one thing">
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
                        <select  name="mainlks" class="form-select"  id="single-select-field-10" data-placeholder="Choose one thing">
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
                        <select  name="edit-lks" class="form-select"  id="single-select-field-8" data-placeholder="Choose one thing">
                            <option selected disabled>Pilih Lokasi</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ruangan<span class="bintang" style="color: red;">*</span></label>
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="inputGroupSelect04"><i class="fadeIn animated bx bx-been-here"></i></label>
                        <select  name="edit-rng" class="form-select"  id="single-select-field-9" data-placeholder="Choose one thing">
                            <option selected disabled>Pilih Ruangan</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kondisi<span class="bintang" style="color: red;">*</span></label>
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="inputGroupSelect05"><i class="fadeIn animated bx bx-message-alt-check"></i></label>
                        <select  name="edit-sts" class="form-select">
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
                        <input type="date" class="form-control" name="edit-tgl_pengadaan" required>
                    </div>
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

<script>
      // --- Dependent Select for Tambah Monitoring ---
        $('#single-select-field-3').on('change', function() {
            var lokasiId = $(this).val();
            var LokasiSelect = $('.lokasi-input');
            LokasiSelect.empty().trigger('change');
            if (lokasiId) {
                $.ajax({
                    url: routeGetLokasi.replace(':id', lokasiId),
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        LokasiSelect.append('<option value="">Pilih Sub Lokasi</option>');
                        $.each(data, function(index, dataLocation) {
                            LokasiSelect.append('<option value="' + dataLocation.id + '">' + dataLocation.keterangan + '</option>');
                        });
                        LokasiSelect.val('').trigger('change');
                    }
                });
            } else {
                LokasiSelect.append('<option value="">Pilih Sub Lokasi</option>').val('').trigger('change');
            }
        });

        $('#single-select-field-4').on('change', function() {
            var ruanganId = $(this).val();
            var RuanganSelect = $('#single-select-field-5');
            RuanganSelect.empty().trigger('change');
            if (ruanganId) {
                $.ajax({
                    url: routeGetRuangan.replace(':id', ruanganId),
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        RuanganSelect.append('<option value="">Pilih Ruangan</option>');
                        $.each(data, function(index, dataRoom) {
                            RuanganSelect.append('<option value="' + dataRoom.id + '">' + dataRoom.deskripsi + '</option>');
                        });
                        RuanganSelect.val('').trigger('change');
                    }
                });
            } else {
                RuanganSelect.append('<option value="">Pilih Ruangan</option>').val('').trigger('change');
            }
        });

        // --- Dependent Select for Edit Monitoring ---
        $('#single-select-field-10').on('change', function() {
            var lokasiId = $(this).val();
            var LokasiSelect = $('#single-select-field-8');
            LokasiSelect.empty().trigger('change');
            if (lokasiId) {
                $.ajax({
                    url: routeGetLokasi.replace(':id', lokasiId),
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        LokasiSelect.append('<option value="">Pilih Sub Lokasi</option>');
                        $.each(data, function(index, dataLocation) {
                            LokasiSelect.append('<option value="' + dataLocation.id + '">' + dataLocation.keterangan + '</option>');
                        });
                        LokasiSelect.val('').trigger('change');
                    }
                });
            } else {
                LokasiSelect.append('<option value="">Pilih Sub Lokasi</option>').val('').trigger('change');
            }
        });

        $('#single-select-field-8').on('change', function() {
            var ruanganId = $(this).val();
            var RuanganSelect = $('#single-select-field-9');
            RuanganSelect.empty().trigger('change');
            if (ruanganId) {
                $.ajax({
                    url: routeGetRuangan.replace(':id', ruanganId),
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        RuanganSelect.append('<option value="">Pilih Ruangan</option>');
                        $.each(data, function(index, dataRoom) {
                            RuanganSelect.append('<option value="' + dataRoom.id + '">' + dataRoom.deskripsi + '</option>');
                        });
                        RuanganSelect.val('').trigger('change');
                    }
                });
            } else {
                RuanganSelect.append('<option value="">Pilih Ruangan</option>').val('').trigger('change');
            }
        });
         $(document).on('click', '#btn-edit-history', function(){
        let id = $(this).data('id');
        const form = document.getElementById('editHistoryForm');
        form.action = routeUpdateHistory.replace(':id', id);
        let finalUrl = urlEditHistory.replace(':id', id);

        $.ajax({
            type: "get",
            url: finalUrl, 
            dataType: 'json',
            success: function(res){
                $('select[name="edit-pggn"]').val(res.id_karyawan).trigger('change');
                $('select[name="edit-dvs"]').val(res.id_divisi).trigger('change');
                $('select[name="mainlks"]').val(res.id_lokasi_utama).trigger('change');

                $.ajax({
                    url: routeGetLokasi.replace(':id', res.id_lokasi_utama),
                    type: 'GET',
                    dataType: 'json',
                    success: function(dataLokasi) {
                        let $lokasiSelect = $('select[name="edit-lks"]');
                        $lokasiSelect.empty().append('<option value="">Pilih Lokasi</option>');
                        $.each(dataLokasi, function(index, lokasi) {
                            $lokasiSelect.append('<option value="' + lokasi.id + '">' + lokasi.keterangan + '</option>');
                        });
                        $lokasiSelect.val(res.id_lokasi).trigger('change');

                        $.ajax({
                            url: routeGetRuangan.replace(':id', res.id_lokasi),
                            type: 'GET',
                            dataType: 'json',
                            success: function(dataRuangan) {
                                let $ruanganSelect = $('select[name="edit-rng"]');
                                $ruanganSelect.empty().append('<option value="">Pilih Ruangan</option>');
                                $.each(dataRuangan, function(index, ruangan) {
                                    $ruanganSelect.append('<option value="' + ruangan.id + '">' + ruangan.deskripsi + '</option>');
                                });
                                $ruanganSelect.val(res.id_ruangan).trigger('change');
                            }
                        });
                    }
                });

                // Set status, tanggal, dan deskripsi
                $('select[name="edit-sts"]').val(res.status).trigger('change');
                $('input[name="edit-tgl_pengadaan"]').val(res.tgl_riwayat ?? '');
                $('textarea[name="edit-deskripsi"]').val(res.keterangan ?? '');
            }
        });            
    });
</script>