// Pastikan variabel route di-inject dari blade ke JS, misal lewat tag <script> di blade, bukan langsung {{ }} di file JS

// Contoh: di blade
// <script>
//   window.routeEditEquipmentVehicle = "{{ route('transaction.edit', ':id') }}";
//   window.routeUpdateEquipmentVehicle = "{{ route('transaction.update', ':id') }}";
//   window.routeDeleteEquipmentVehicle = "{{ route('transaction.destroy', ':id') }}";
//   window.routeGetMobil = "{{ route('transaction.getVehicles') }}";
//   window.routeGetEmployee = "{{ route('transaction.employee', ':id') }}";
//   window.perlengkapanMobil = @json($perlengkapan_mobil);
//   window.perlengkapanPetugas = @json($perlengkapan_petugas);
// </script>

// Kemudian di file JS:
const urlEditEquipmentVehicle = window.routeEditEquipmentVehicle;
const routeUpdateEquipmentVehicle = window.routeUpdateEquipmentVehicle;
const routeDeleteEquipmentVehicle = window.routeDeleteEquipmentVehicle;
const routeGetMobil = window.routeGetMobil;
const routeGetEmployee = window.routeGetEmployee;
const perlengkapanMobil = window.perlengkapanMobil || [];
const perlengkapanPetugas = window.perlengkapanPetugas || [];

// Asynchronous: Edit kendaraan
$(document).on('click', '.btn-edit-kendaraan', async function() {
    const id = $(this).data('id');
    const url = urlEditEquipmentVehicle.replace(':id', id);
    $('#form-edit-kendaraan').attr('action', routeUpdateEquipmentVehicle.replace(':id', id));
    $('#form-edit-kendaraan').attr('method', 'POST');
    try {
        const res = await fetch(url);
        const data = await res.json();
        $('#editModal #edit-waktu_pemakaian').val(data.tanggal_penjadwalan);
        $('#editModal #edit-shift').val(data.shift).trigger('change');
        $('#editModal #edit-vehicle_id').val(data.id_mobil).trigger('change');
        // Render perlengkapan
        const wrapper = $('#editModal #perlengkapan-wrapper-mobil');
        wrapper.empty();
        if (data.perlengkapan && data.perlengkapan.length > 0) {
            data.perlengkapan.forEach(item => {
                let options = '';
                perlengkapanMobil.forEach(p => {
                    options += `<option value="${p.id}" ${item.perlengkapan_id == p.id ? 'selected' : ''}>${p.nama_perlengkapan}</option>`;
                });
                wrapper.append(`
                    <div class="row g-2 mb-2 perlengkapan-item">
                        <input type="hidden" name="perlengkapan_item_id[]" value="${item.id}">
                        <div class="col-md-7">
                            <select name="perlengkapan_id_mobil[]" class="form-select" required>
                                <option value="" disabled>-- Pilih Perlengkapan --</option>
                                ${options}
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="number" name="jumlah-mobil[]" class="form-control" placeholder="Jumlah" min="1" value="${item.jumlah}" required>
                        </div>
                        <div class="col-md-2 d-grid">
                            <button type="button" class="btn btn-danger remove-row"><i class="fadeIn animated bx bx-trash"></i></button>
                        </div>
                    </div>
                `);
            });
        } else {
            wrapper.append(`<p class="text-muted">Tidak ada perlengkapan yang dipilih.</p>`);
        }
        $('#editModal').modal('show');
    } catch (err) {
        alert('Gagal memuat data edit!');
    }
});

// Hapus perlengkapan mobil pada modal tambah
$(document).on('click', '.remove-row', function () {
    $(this).closest('.perlengkapan-item').remove();
});
// Hapus perlengkapan petugas pada modal tambah petugas
$(document).on('click', '.remove-row-petugas', function () {
    $(this).closest('.perlengkapan-item-petugas').remove();
});

// Asynchronous: Get kendaraan by tanggal & shift
$(document).ready(function () {
    function loadVehicles() {
        let tanggal = $('#waktu_pemakaian').val();
        let shift   = $('#shift').val();
        if (!tanggal || !shift) return;
        $('#vehicle_id').empty().append('<option value="" selected disabled>-- Pilih Kendaraan --</option>');
        $.ajax({
            url: routeGetMobil,
            type: 'GET',
            data: { tanggal: tanggal, shift: shift },
            dataType: 'json',
            success: function (data) {
                if (data.length === 0) {
                    $('#vehicle_id').append('<option disabled>Tidak ada kendaraan tersedia</option>');
                } else {
                    data.forEach(function (vehicle) {
                        $('#vehicle_id').append(
                            `<option value="${vehicle.nomesin}">${vehicle.nomesin} - ${vehicle.jenis ?? ''}</option>`
                        );
                    });
                }
            }
        });
    }
    $('#waktu_pemakaian, #shift').on('change', loadVehicles);
});

// Asynchronous: Tambah petugas
$(document).on('click', '.btn-tambah-petugas', function () {
    let id = $(this).data('id');
    $('#form-tambah-petugas').attr('action', window.routeStorePetugas.replace(':id', id));
    function loadEmployee() {
        let $selects = $('.employe-select');
        $selects.empty().append('<option value="" selected disabled>-- Pilih Petugas --</option>');
        $.ajax({
            url: routeGetEmployee.replace(':id', id),
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                if (!data || data.length === 0) {
                    $selects.append('<option disabled>Tidak ada petugas tersedia</option>');
                } else {
                    data.forEach(function (employee) {
                        let jabatan = employee.jabatan ? ` - ${employee.jabatan}` : '';
                        let option = `<option value="${employee.id}">${employee.nama}${jabatan}</option>`;
                        $selects.append(option);
                    });
                }
            }
        });
    }
    loadEmployee();
    $('#waktu_pemakaian, #shift').off('change.loadEmployee').on('change.loadEmployee', loadEmployee);
});

// Asynchronous: Edit petugas
$(document).on('click', '.btn-edit-petugas', async function() {
    const id = $(this).data('id');
    const url = window.routeEditPetugas.replace(':id', id);
    $('#form-edit-petugas').attr('action', window.routeUpdatePetugas.replace(':id', id));
    $('#form-edit-petugas').attr('method', 'POST');
    try {
        const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } });
        const data = await res.json();
        $('#edit-employe-id1').val(data.id_petugas_1).trigger('change');
        $('#edit-employe-id2').val(data.id_petugas_2).trigger('change');
        $('#edit-employe-id3').val(data.id_petugas_3).trigger('change');
        $('#edit-employe-id4').val(data.id_petugas_4).trigger('change');
        const wrapper = $('#editPetugas #edit-perlengkapan-wrapper-petugas');
        wrapper.empty();
        if (data.perlengkapan && data.perlengkapan.length > 0) {
            data.perlengkapan.forEach(item => {
                let options = '';
                perlengkapanPetugas.forEach(p => {
                    options += `<option value="${p.id}" ${item.perlengkapan_id == p.id ? 'selected' : ''}>${p.nama_perlengkapan}</option>`;
                });
                wrapper.append(`
                    <div class="row g-2 mb-2 edit-perlengkapan-item">
                        <input type="hidden" name="perlengkapan_item_id[]" value="${item.id}">
                        <div class="col-md-7">
                            <select name="perlengkapan_id[]" class="form-select" required>
                                <option value="" disabled>-- Pilih Perlengkapan --</option>
                                ${options}
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah" min="1" value="${item.jumlah}" required>
                        </div>
                        <div class="col-md-2 d-grid">
                            <button type="button" class="btn btn-danger remove-row"><i class="fadeIn animated bx bx-trash"></i></button>
                        </div>
                    </div>
                `);
            });
        } else {
            wrapper.append(`<p class="text-muted">Tidak ada perlengkapan yang dipilih.</p>`);
        }
        $('#editPetugas').modal('show');
    } catch (err) {
        alert('Gagal memuat data edit!');
    }
});

// Asynchronous: Perlengkapan Mobil & Petugas (checkbox)
$(document).on('click', '.btn-perlengkapan-mobil', function () {
    let id = $(this).data('id');
    let url = window.routePerlengkapanGet.replace(':id', id);
    $.get(url, function (res) {
        let container = $('#form-perlengkapan-mobil .row');
        container.empty();
        $.each(res.perlengkapan, function (i, item) {
            let checked = res.perlengkapanTerpilih.some(p => p.id === item.id) ? 'checked' : '';
            let html = `
                <div class="col-md-6 col-lg-4">
                    <div class="form-check border rounded-3 p-2 shadow-sm h-100">
                        <input class="form-check-input" type="checkbox"
                            id="check_${i}" name="barang[]"
                            value="${item.id}" ${checked}>
                        <label class="form-check-label ms-1" for="check_${i}">
                            ${item.master_perlengkapan.nama_perlengkapan} (qty: ${item.jumlah})
                        </label>
                    </div>
                </div>`;
            container.append(html);
        });
    });
});
$(document).on('click', '.btn-perlengkapan-petugas', function () {
    let id = $(this).data('id');
    let url = window.routePerlengkapanPetugasGet.replace(':id', id);
    $.get(url, function (res) {
        let container = $('#form-perlengkapan-petugas .row');
        container.empty();
        $.each(res.perlengkapan, function (i, item) {
            let checked = res.perlengkapanTerpilih.some(p => p.id === item.id) ? 'checked' : '';
            let html = `
                <div class="col-md-6 col-lg-4">
                    <div class="form-check border rounded-3 p-2 shadow-sm h-100">
                        <input class="form-check-input" type="checkbox"
                            id="check_${i}" name="barang[]"
                            value="${item.id}" ${checked}>
                        <label class="form-check-label ms-1" for="check_${i}">
                            ${item.master_perlengkapan.nama_perlengkapan} (qty: ${item.jumlah})
                        </label>
                    </div>
                </div>`;
            container.append(html);
        });
    });
});