  <aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
      <div class="logo-icon">
        <i class="lni lni-pencil-alt"></i>
      </div>
      <div class="logo-name flex-grow-1">
        <h5 class="mb-0">APLIKASI DIVISI</h5>
      </div>
      <div class="sidebar-close">
        <span class="material-icons-outlined">close</span>
      </div>
    </div>
    <div class="sidebar-nav"> 
      <!--navigation-->
      <ul class="metismenu" id="sidenav">
        <li class="{{ request()->is('/') ? 'mm-active' : '' }}">
          <a href="{{ Route('home') }}">
            <div class="parent-icon"><i class="material-icons-outlined">home</i>
            </div>
            <div class="menu-title">Dashboard</div>
          </a>
        </li>

        @can('menu.master-data')
          <li>
            <a class="has-arrow" href="javascript:;">
              <div class="parent-icon"><i class="material-icons-outlined">widgets</i>
              </div>
              <div class="menu-title">Master Data</div>
            </a>
            <ul>

              <li><a class="has-arrow" href="javascript:;"><i class="material-icons-outlined">arrow_right</i>Unit
                  Kerja</a>
                <ul>
                  @if (Auth::user()->hasRole('super-admin'))
                    <li><a href="{{ route('company.index') }}"><i
                          class="material-icons-outlined">arrow_right</i>Perusahaan</a>
                    </li>
                  @endif

                  <li><a href="{{ route('directorate.index') }}"><i
                        class="material-icons-outlined">arrow_right</i>Direktorat</a>
                  </li>
                  <li><a href="{{ route('division.index') }}"><i class="material-icons-outlined">arrow_right</i>Divisi</a>
                  </li>
                  <li><a href="{{ route('department.index') }}"><i
                        class="material-icons-outlined">arrow_right</i>Departemen</a>
                  </li>
                  <li><a href="{{ route('section.index') }}"><i class="material-icons-outlined">arrow_right</i>Seksi</a>
                  </li>
                </ul>
              </li>

              {{-- <li><a class="has-arrow" href="javascript:;"><i class="material-icons-outlined">arrow_right</i>Anggaran</a>
              <ul>
                <li><a href="{{ route('budget-account.index') }}"><i
                      class="material-icons-outlined">arrow_right</i>COA</a>
                </li>
                <li><a href="{{ route('budget-plan-detail.index') }}"><i
                      class="material-icons-outlined">arrow_right</i>RKAP</a>
                </li>
              </ul>
            </li> --}}

	   <li><a class="has-arrow" href="javascript:;"><i class="material-icons-outlined">arrow_right</i>Budget</a>
                <ul>

                  <li>
                    <a href="{{ route('budget-category.index') }}">
                      <i class="material-icons-outlined">arrow_right</i>
                      Kategori Budget </a>
                  </li>
                  {{-- 
                  <li>
                    <a href="{{ route('stage-group.index', ['type' => 'pekerjaan']) }}">
                      <i class="material-icons-outlined">arrow_right</i>
                      Tahapan Pekerjaan </a>
                  </li>

                  <li>
                    <a href="{{ route('stage-group.index', ['type' => 'pembayaran']) }}">
                      <i class="material-icons-outlined">arrow_right</i>
                      Tahapan Pembayaran </a>
                  </li> --}}

                </ul>
              </li>

           {{--   <li><a class="has-arrow" href="javascript:;"><i class="material-icons-outlined">arrow_right</i>Tahapan</a>
                <ul>

                  <li>
                    <a href="{{ route('stage-group.index', ['type' => 'anggaran']) }}">
                      <i class="material-icons-outlined">arrow_right</i>
                      Tahapan Anggaran </a>
                  </li>

                  <li>
                    <a href="{{ route('stage-group.index', ['type' => 'pekerjaan']) }}">
                      <i class="material-icons-outlined">arrow_right</i>
                      Tahapan Pekerjaan </a>
                  </li>

                  <li>
                    <a href="{{ route('stage-group.index', ['type' => 'pembayaran']) }}">
                      <i class="material-icons-outlined">arrow_right</i>
                      Tahapan Pembayaran </a>
                  </li>

                </ul>
              </li> --}}

              {{-- <li>
                <a href="{{ route('stage-group.index') }}">
                  <i class="material-icons-outlined">arrow_right</i> Tahapan </a>
              </li> --}}


              {{-- <li class="{{ request()->is('user/*/edit', 'user/create') ? 'mm-active' : '' }}">
              <a href="{{ Route('fixedaset.index') }}">
                <i class="material-icons-outlined">arrow_right</i>Fixed Asset Number
              </a>
            </li> --}}
              <li class="{{ request()->is('barang/*/edit', 'barang/create') ? 'mm-active' : '' }}">
                <a href="javascript:;" class="has-arrow d-flex align-items-center">
                  <i class="material-icons-outlined me-2">arrow_right</i>
                  <span>Barang</span>
                </a>
                <ul>
                  <li>
                    <a href="{{ Route('catagory.index') }}" class="d-flex align-items-center">
                      <i class="material-icons-outlined me-2">arrow_right</i>
                      <span>Katagori Barang</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{ Route('barang.index') }}" class="d-flex align-items-center">
                      <i class="material-icons-outlined me-2">arrow_right</i>
                      <span>Sub Barang</span>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="{{ request()->is('kondisi/*/edit', 'kondisi/create') ? 'mm-active' : '' }}">


                {{-- <li>
              <a href="{{ route('purchase-request.index') }}">
                <div class="parent-icon"><i class="material-icons-outlined">arrow_right</i>
                </div>
                <div class="menu-title">Purchase Request</div>
              </a>
            </li> --}}

                {{-- <li class="{{ request()->is('barang/*/edit', 'barang/create') ? 'mm-active' : '' }}">
          <a href="{{ Route('barang.index') }}">
            <i class="material-icons-outlined">arrow_right</i>Barang
          </a>
        </li> --}}
              <li class="{{ request()->is('kondisi/*/edit', 'kondisi/create') ? 'mm-active' : '' }}">

                <a href="{{ Route('kondisi.index') }}">
                  <i class="material-icons-outlined">arrow_right</i>Kondisi
                </a>
              </li>
              <li class="{{ request()->is('karyawan/*/edit', 'karyawan/create') ? 'mm-active' : '' }}">
                <a href="{{ Route('karyawan.index') }}">
                  <i class="material-icons-outlined">arrow_right</i>Karyawan
                </a>
              </li>
              <li>
                <a href="javascript:;" class="has-arrow d-flex align-items-center">
                  <i class="material-icons-outlined me-2">arrow_right</i>
                  <span>Lokasi</span>
                </a>
                <ul>
                  <li class="{{ request()->is('lokasi-utama/*/edit', 'lokasi-utama/create') ? 'mm-active' : '' }}">
                    <a href="{{ Route('mainlocations.index') }}" class="d-flex align-items-center">
                      <i class="material-icons-outlined me-2">arrow_right</i>
                      <span>Lokasi Utama</span>
                    </a>
                  </li>
                  <li class="{{ request()->is('sub-lokasi/*/edit', 'sub-lokasi/create') ? 'mm-active' : '' }}">
                    <a href="{{ Route('locations.index') }}" class="d-flex align-items-center">
                      <i class="material-icons-outlined me-2">arrow_right</i>
                      <span>Sub lokasi</span>
                    </a>
                  </li>
                  <li class="{{ request()->is('lokasi/*/edit', 'lokasi/create') ? 'mm-active' : '' }}">
                    <a href="{{ Route('rooms.index') }}" class="d-flex align-items-center">
                      <i class="material-icons-outlined me-2">arrow_right</i>
                      <span>Detail Lokasi</span>
                    </a>
                  </li>
                </ul>
              </li>

              {{-- <li class="{{ request()->is('ruangan/*/edit', 'ruangan/create') ? 'mm-active' : '' }}">
                <a href="{{ Route('rooms.index') }}">
                  <i class="material-icons-outlined">arrow_right</i>Ruangan
                </a>
              </li> --}}
              {{-- <li class="{{ request()->is('divisi/*/edit', 'divisi/create') ? 'mm-active' : '' }}">
            <li class="{{ request()->is('divisi/*/edit', 'divisi/create') ? 'mm-active' : '' }}">

              <a href="{{ Route('divisions.index') }}">
                <i class="material-icons-outlined">arrow_right</i>Divisi
              </a>
            </li> --}}
              <li class="{{ request()->is('pejabat/*/edit', 'pejabat/create') ? 'mm-active' : '' }}">
                <a href="{{ Route('placeman.index') }}">
                  <i class="material-icons-outlined">arrow_right</i>Pejabat
                </a>
              </li>

            </ul>
          </li>
        @endcan

 @can('menu.tahapan')
          <li>
            <a class="has-arrow" href="javascript:;">
              <div class="parent-icon"><i class="material-icons-outlined">toc</i>
              </div>
              
              <div class="menu-title">Tahapan</div>
            </a>
            <ul>
              <li>
                <a href="{{ route('stage-group.index', ['type' => 'pekerjaan']) }}">
                  <i class="material-icons-outlined">arrow_right</i>
                  Tahapan Pekerjaan </a>
              </li>

             <li>
                <a href="{{ route('stage-group.index', ['type' => 'finalcontrol']) }}">
                  <i class="material-icons-outlined">arrow_right</i>
                  Tahapan Final Control </a>
              </li>
            </ul>
          </li>
        @endcan

 @can('menu.anggaran')
          <li>
            <a class="has-arrow" href="javascript:;">
              <div class="parent-icon"><i class="material-icons-outlined">toc</i>
              </div>
              <div class="menu-title">Anggaran</div>
            </a>
            <ul>
              {{-- <li><a href="{{ route('budget-plan.index') }}"><i class="material-icons-outlined">arrow_right</i>COA</a>
              </li> 
              <li><a href="{{ route('budget-plan-detail.index') }}"><i
                    class="material-icons-outlined">arrow_right</i>RKAP</a>
              </li> --}}
              <li><a href="{{ route('budget-plan.index') }}"><i
                    class="material-icons-outlined">arrow_right</i>RKAP</a>
              </li>
              <li><a href="{{ route('work-plan.index') }}"><i class="material-icons-outlined">arrow_right</i>Rencana
                  Pekerjaan</a>
              </li>
              {{-- <li><a href="{{ route('purchase-request-sap.index') }}"><i
                    class="material-icons-outlined">arrow_right</i>PR</a>
              </li> --}}
            </ul>
          </li>
        @endcan


@can('menu.master-data-ahs-user')
          <li>
            <a class="has-arrow" href="javascript:;">
              <div class="parent-icon"><i class="material-icons-outlined">fitbit</i>
              </div>
              <div class="menu-title">AHS Master Data</div>
            </a>
            <ul>

              @can('unit.index')
              @endcan
              <li><a href="{{ route('unit.index') }}">
                  <i class="material-icons-outlined">arrow_right</i>Satuan</a>
              </li>
              <li>
                <a href="{{ route('material.index') }}">
                  <i class="material-icons-outlined">arrow_right</i>Material</a>
              </li>
              <li>
                <a href="{{ route('labor.index') }}">
                  <i class="material-icons-outlined">arrow_right</i>Tenaga Kerja</a>
              </li>
              <li>
                <a href="{{ route('equipment.index') }}">
                  <i class="material-icons-outlined">arrow_right</i>Peralatan</a>
              </li>
              <li>
                <a href="{{ route('misc.index') }}">
                  <i class="material-icons-outlined">arrow_right</i>Lain-lain</a>
              </li>

              {{-- <li><a href="{{ route('main-job.index') }}"><i class="material-icons-outlined">arrow_right</i>Analis
                Harga Satuan</a>
            </li> --}}
            </ul>
          </li>
        @endcan

        @can('menu.ahs-pnp')
          <li>
            <a href="{{ route('main-job-pnp.index') }}">
              <div class="parent-icon"><i class="material-icons-outlined">inventory_2</i>
              </div>
              <div class="menu-title">Analisa Harga Satuan</div>
            </a>
          </li>
        @endcan
        @can('menu.ahs-teknik')
          <li>
            <a href="{{ route('main-job-teknik.index') }}">
              <div class="parent-icon"><i class="material-icons-outlined">inventory_2</i>
              </div>
              <div class="menu-title">Analisa Harga Satuan.</div>
            </a>
          </li>
        @endcan


        @can('menu.purchase-request')
          <li>
            <a href="{{ route('work.index') }}">
              <div class="parent-icon"><i class="material-icons-outlined">view_agenda</i>
              </div>
              <div class="menu-title">Pekerjaan</div>
            </a>
          </li>
        @endcan

	 @can('menu.master-data-aset')
          <li>
            <a class="has-arrow" href="javascript:;">
              <div class="parent-icon"><i class="material-icons-outlined">widgets</i>
              </div>
              <div class="menu-title">Master Data</div>
            </a>
            <ul>
              <li class="{{ request()->is('barang/*/edit', 'barang/create') ? 'mm-active' : '' }}">
                <a href="javascript:;" class="has-arrow d-flex align-items-center">
                  <i class="material-icons-outlined me-2">arrow_right</i>
                  <span>Barang</span>
                </a>
                <ul>
                  <li>
                    <a href="{{ Route('catagory.index') }}" class="d-flex align-items-center">
                      <i class="material-icons-outlined me-2">arrow_right</i>
                      <span>Katagori Barang</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{ Route('barang.index') }}" class="d-flex align-items-center">
                      <i class="material-icons-outlined me-2">arrow_right</i>
                      <span>Sub Barang</span>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="{{ request()->is('kondisi/*/edit', 'kondisi/create') ? 'mm-active' : '' }}">

              <li class="{{ request()->is('kondisi/*/edit', 'kondisi/create') ? 'mm-active' : '' }}">
                <a href="{{ Route('kondisi.index') }}">
                  <i class="material-icons-outlined">arrow_right</i>Kondisi
                </a>
              </li>
              <li>
                <a href="javascript:;" class="has-arrow d-flex align-items-center">
                  <i class="material-icons-outlined me-2">arrow_right</i>
                  <span>Lokasi</span>
                </a>
                <ul>
                  <li class="{{ request()->is('lokasi-utama/*/edit', 'lokasi-utama/create') ? 'mm-active' : '' }}">
                    <a href="{{ Route('mainlocations.index') }}" class="d-flex align-items-center">
                      <i class="material-icons-outlined me-2">arrow_right</i>
                      <span>Lokasi Utama</span>
                    </a>
                  </li>
                  <li class="{{ request()->is('sub-lokasi/*/edit', 'sub-lokasi/create') ? 'mm-active' : '' }}">
                    <a href="{{ Route('locations.index') }}" class="d-flex align-items-center">
                      <i class="material-icons-outlined me-2">arrow_right</i>
                      <span>Sub lokasi</span>
                    </a>
                  </li>
                  <li class="{{ request()->is('lokasi/*/edit', 'lokasi/create') ? 'mm-active' : '' }}">
                    <a href="{{ Route('rooms.index') }}" class="d-flex align-items-center">
                      <i class="material-icons-outlined me-2">arrow_right</i>
                      <span>Detail Lokasi</span>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
        @endcan
	

    {{--    @can('menu.anggaran')
          <li>
            <a class="has-arrow" href="javascript:;">
              <div class="parent-icon"><i class="material-icons-outlined">toc</i>
              </div>
              <div class="menu-title">Anggaran</div>
            </a>
            <ul>
              <li><a href="{{ route('budget-account.index') }}"><i class="material-icons-outlined">arrow_right</i>COA</a>
              </li>
              <li><a href="{{ route('budget-plan-detail.index') }}"><i
                    class="material-icons-outlined">arrow_right</i>RKAP</a>
              </li>
              <li><a href="{{ route('budget-account.index') }}"><i class="material-icons-outlined">arrow_right</i>BUDGET</a>
              </li>
              <li><a href="{{ route('purchase-request-sap.index') }}"><i
                    class="material-icons-outlined">arrow_right</i>PR</a>
              </li>
            </ul>
          </li>
        @endcan

        @can('menu.purchase-request')
          <li>
            <a href="{{ route('purchase-request.index') }}">
              <div class="parent-icon"><i class="material-icons-outlined">view_agenda</i>
              </div>
              <div class="menu-title">PR</div>
            </a>
          </li>
        @endcan --}}


        
        {{-- @can('menu.purchase-request')
          <li>
            <a href="{{ route('purchase-request.index') }}">
              <div class="parent-icon"><i class="material-icons-outlined">view_agenda</i>
              </div>
              <div class="menu-title">Purchase Request</div>
            </a>
          </li>
        @endcan --}}

        {{-- <li>
          <a href="{{ Route('fixedaset.index') }}">
            <div class="parent-icon"><i class="material-icons-outlined">card_giftcard</i>
            </div>
            <div class="menu-title">Fixed Asset Number</div>
          </a>
        </li> --}}

        @can('menu.barang')
          <li>
            <a href="javascript:;" class="has-arrow">
              <div class="parent-icon"><i class="material-icons-outlined">description</i>
              </div>
              <div class="menu-title">Barang</div>
            </a>
            <ul>
              <li
                class="{{ request()->is('bapb-barang/*/create', 'bapb/create', 'bapb/*/edit', 'bapb-barang/*/barang') ? 'mm-active' : '' }}">
                <a href="{{ Route('bapb.index') }}">
                  <i class="material-icons-outlined">arrow_right</i>BAPB
                </a>
              </li>
              <li>
                <a href="{{ Route('bapbbarang.index') }}">
                  <i class="material-icons-outlined">arrow_right</i>Non BAPB
                </a>
              </li>
              <li
                class="{{ request()->is('pencatatan/*/edit', 'pencatatan/*/show', 'stock-opname/*/history') ? 'mm-active' : '' }}">
                <a href="{{ Route('pencatatan.index') }}">
                  <i class="material-icons-outlined">arrow_right</i>Data Aset
                </a>
              </li>
              {{-- <li>
              <a href="javascript:;" class="has-arrow d-flex align-items-center">
                <i class="material-icons-outlined me-2">arrow_right</i>
                <span>Monitoring Barang</span>
              </a>
              <ul>
                <li class="{{ request()->is('stock-opname/monitoring') ? 'mm-active' : '' }}">
                  <a href="{{ Route('stockopname.monitoring') }}" class="d-flex align-items-center">
                    <i class="material-icons-outlined me-2">arrow_right</i>
                    <span>Monitoring Aset</span>
                  </a>
                </li>
                <li>
                  <a href="#" class="d-flex align-items-center">
                    <i class="material-icons-outlined me-2">arrow_right</i>
                    <span>Laporan Barang Rusak</span>
                  </a>
                </li>
                <li>
                  <a href="#" class="d-flex align-items-center">
                    <i class="material-icons-outlined me-2">arrow_right</i>
                    <span>Lelang</span>
                  </a>
                </li>
              </ul>
            </li> --}}
	       <li>
                <a href="{{ Route('pencatatan.reminder') }}">
                  <i class="material-icons-outlined">arrow_right</i> Reminder Data Aset 
                </a>
              </li>
              <li>
                <a href="{{ Route('stockopname.index') }}">
                  <i class="material-icons-outlined">arrow_right</i> Laporan Monitoring
                </a>
              </li>
              <li>
                <a href="{{ Route('demageAset.index') }}">
                  <i class="material-icons-outlined">arrow_right</i> Laporan Barang Rusak
                </a>
              </li>
              <li>
                <a href="{{ Route('demageAset.monitoring.index') }}">
                  <i class="material-icons-outlined">arrow_right</i> Monitoring Barang Rusak
                </a>
              </li>
              <li>
                <a href="{{ Route('asetLelang.index') }}">
                  <i class="material-icons-outlined">arrow_right</i> Laporan Barang Lelang
                </a>
              </li>
              <li class="{{ request()->is('barang-lelang/*/edit') ? 'mm-active' : '' }}">
                <a href="{{ Route('asetLelang.monitoring.index') }}">
                  <i class="material-icons-outlined">arrow_right</i> Monitoring Barang Lelang
                </a>
              </li>
              <li>
                <a href="{{ Route('fixedaset.index') }}">
                  <i class="material-icons-outlined">arrow_right</i> Fixed Asset Number
                </a>
              </li>
            </ul>
          </li>
        @endcan

        @can('menu.monitoring-aset')
          <li class="{{ request()->is('stock-opname/monitoring') ? 'mm-active' : '' }}">
            <a href="{{ Route('stockopname.monitoring') }}">
              <div class="parent-icon"><i class="material-icons-outlined">face_5</i>
              </div>
              <div class="menu-title">Monitoring Aset</div>
            </a>
          </li>
        @endcan

        @can('menu.kendaraan')
          <li>
            <a href="javascript:;" class="has-arrow">
              <div class="parent-icon p-1"><i class="lni lni-car-alt"></i>
              </div>
              <div class="menu-title">Kendaraan</div>
            </a>
            <ul>
              <li class="{{ request()->is('merk/*/edit', 'merk/create') ? 'mm-active' : '' }}">
                <a href="{{ Route('vehiclebrand.index') }}">
                  <i class="material-icons-outlined">arrow_right</i>Merk Kendaraan
                </a>
              </li>
              <li class="{{ request()->is('tipe/*/edit', 'tipe/create') ? 'mm-active' : '' }}">
                <a href="{{ Route('vehicletype.index') }}">
                  <i class="material-icons-outlined">arrow_right</i>Tipe Kendaraan
                </a>
              </li>
              <li class="{{ request()->is('jenis/*/edit', 'jenis/create') ? 'mm-active' : '' }}">
                <a href="{{ Route('vehicleclass.index') }}">
                  <i class="material-icons-outlined">arrow_right</i>Jenis Kendaraan
                </a>
              </li>
              <li
                class="{{ request()->is('kendaraan/*/edit', 'kendaraan/*/show', 'proses/*/create', 'stnk/*/create') ? 'mm-active' : '' }}">
                <a href="{{ Route('vehicles.index') }}">
                  <i class="material-icons-outlined">arrow_right</i>Master Kendaraan
                </a>
              </li>
              <li>
                <a href="{{ Route('vehicles.create') }}">
                  <i class="material-icons-outlined">arrow_right</i>Tambah Data Kendaraan
                </a>
              </li>
            </ul>
          </li>
        @endcan
	@can('menu.peminjaman-kendaraan')
          <li>
            <a href="javascript:;" class="has-arrow">
              <div class="parent-icon p-1"><i class="fadeIn animated bx bx-traffic-cone"></i>
              </div>
              <div class="menu-title">Pinjaman Kendaraan</div>
            </a>
            <ul>
              <li class="{{ request()->is('merk/*/edit', 'merk/create') ? 'mm-active' : '' }}">
                <a href="{{ Route('vehicleLending.index') }}">
                  <i class="material-icons-outlined">arrow_right</i> Peminjaman
                </a>
              </li>
              <li class="{{ request()->is('tipe/*/edit', 'tipe/create') ? 'mm-active' : '' }}">
                <a href="{{ Route('managementLending.index') }}">
                  <i class="material-icons-outlined">arrow_right</i>Manajemen Peminjaman
                </a>
              </li>
              <li class="{{ request()->is('tipe/*/edit', 'tipe/create') ? 'mm-active' : '' }}">
                <a href="{{ Route('masterLending.index') }}">
                  <i class="material-icons-outlined">arrow_right</i>Master Kendaraan
                </a>
              </li>
            </ul>
          </li>
        @endcan
	@can('menu.monitoring-p&p')
          <li>
            <a href="javascript:;" class="has-arrow">
              <div class="parent-icon p-1"><i class="lni lni-delivery"></i>
              </div>
              <div class="menu-title">Monitoring P&P</div>
            </a>
            <ul>
              <li >
                <a href="{{ Route('transaction.index') }}">
                  <i class="material-icons-outlined">arrow_right</i>Monitoring Mobil P&P
                </a>
              </li>
	      <li>
                <a href="{{ Route('masterVehicle.index') }}">
                  <i class="material-icons-outlined">arrow_right</i>Master Kendaraan P&P
                </a>
              </li>
              <li >
                <a href="{{ Route('masterEquipment.index') }}">
                  <i class="material-icons-outlined">arrow_right</i>Master Kelengkapan
                </a>
              </li>
            </ul>
          </li>
        @endcan
        {{-- <li>
          <a class="has-arrow" href="javascript:;">
            <div class="parent-icon"><i class="material-icons-outlined">face_5</i>
            </div>
            <div class="menu-title">Menu Levels</div>
          </a>
          <ul>
            <li><a class="has-arrow" href="javascript:;"><i class="material-icons-outlined">arrow_right</i>Level
                One</a>
              <ul>
                <li><a class="has-arrow" href="javascript:;"><i class="material-icons-outlined">arrow_right</i>Level
                    Two</a>
                  <ul>
                    <li><a href="javascript:;"><i class="material-icons-outlined">arrow_right</i>Level Three</a>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
          </ul>
        </li>
        <li> --}}

        @can('menu.laporan')
          <li>
            <a href="javascript:;" class="has-arrow">
              <div class="parent-icon p-1"><i class="lni lni-printer"></i>
              </div>
              <div class="menu-title">Laporan</div>
            </a>
            <ul>
              <li><a href="{{ Route('report.aset') }}"><i class="material-icons-outlined">arrow_right</i>Aset /
                  Tanggal</a>
              </li>
              <li><a href="{{ Route('report.jenisTanggal') }}"><i class="material-icons-outlined">arrow_right</i>Jenis
                  /
                  Tanggal</a>
              </li>
              <li><a href="{{ Route('report.tanggalJenis') }}"><i
                    class="material-icons-outlined">arrow_right</i>Tanggal
                  / Jenis</a>
              </li>
		<li><a href="{{ Route('report.penggunaLokasi') }}"><i
                    class="material-icons-outlined">arrow_right</i>Lokasi
                  / Pengguna</a>
              </li>
		<li><a href="{{ Route('report.kategori') }}"><i class="material-icons-outlined">arrow_right</i>By Kategori
                  Barang</a>
              </li>
              <li><a href="{{ Route('report.divisi') }}"><i class="material-icons-outlined">arrow_right</i>By Divisi</a>
              </li>
            </ul>
          </li>
        @endcan
	@can('menu.ruang-rapat')
          <li>
            <a href="javascript:;" class="has-arrow">
              <div class="parent-icon p-1"><i class="fadeIn animated bx bx-door-open"></i>
              </div>
              <div class="menu-title">Ruang Rapat</div>
            </a>
            <ul>
              <li><a href="{{ Route('transactionMeetingRoom.index') }}"><i class="material-icons-outlined">arrow_right</i>
                  Transaksi Ruang Rapat</a>
              </li>
              <li class="">
                  <a href="javascript:;" class="has-arrow d-flex align-items-center">
                    <i class="material-icons-outlined me-2">arrow_right</i>
                    <span>Administrasi</span>
                  </a>
                  <ul>
                      <li>
                        <a href="{{ Route('ruangRapat.index') }}" class="d-flex align-items-center">
                          <i class="material-icons-outlined me-2">arrow_right</i>
                          <span>Master Ruang Rapat</span>
                        </a>
                      </li>
                       <li class="{{ request()->is('ruang-rapat/view/*/edit') ? 'mm-active' : '' }}">
                        <a href="{{ Route('transactionMeetingRoom.verifikasi') }}" class="d-flex align-items-center">
                          <i class="material-icons-outlined me-2">arrow_right</i>
                          <span>Verifikasi Ruang Rapat</span>
                        </a>
                      </li>
                      <li>
                        <a href="javascript:;" class="has-arrow d-flex align-items-center">
                          <i class="material-icons-outlined me-2">arrow_right</i>
                          <span>PJ & Anggaran</span>
                        </a>
                        <ul>
                          <li>
                            <a href="{{ Route('anggaran.index') }}" class="d-flex align-items-center">
                              <i class="material-icons-outlined me-2">arrow_right</i>
                              <span>Anggaran Tahunan</span>
                            </a>
                          </li>
                          <li>
                            <a href="{{ Route('anggaran-divisi.index') }}" class="d-flex align-items-center">
                              <i class="material-icons-outlined me-2">arrow_right</i>
                              <span>Anggaran Per Divisi</span>
                            </a>
                          </li>
                          <li class="{{ request()->is('ruang-rapat/PJ/create', 'ruang-rapat/PJ/*/edit') ? 'mm-active' : '' }}">
                            <a href="{{ Route('PJruangRapat.index') }}" class="d-flex align-items-center">
                              <i class="material-icons-outlined me-2">arrow_right</i>
                              <span>PJ Rapat</span>
                            </a>
                          </li>
                        </ul>
                      </li>
                  </ul>
              </li>
            </ul>
          </li>
        @endcan
	@can('menu.ams')
          <li>
            <a href="javascript:;" class="has-arrow">
              <div class="parent-icon p-1"><i class="fadeIn animated bx bx-envelope"></i>
              </div>
              <div class="menu-title">AMS</div>
            </a>
            <ul>
              <li class="{{ request()->is('ams/*/edit', 'ams/create') ? 'mm-active' : '' }}"
		><a href="{{ Route('transaksiAms.index') }}"><i class="material-icons-outlined">arrow_right</i>
                  Transaksi Surat</a>
              </li>
              <li><a href="{{ Route('nomorSurat.index') }}"><i class="material-icons-outlined">arrow_right</i>Nomor Surat</a>
              </li>
              <li><a href="{{ Route('klasifikasi.index') }}"><i
                    class="material-icons-outlined">arrow_right</i>Klasifikasi</a>
              </li>
            </ul>
          </li>
        @endcan
        @can('menu.form')
          <li>
            <a href="javascript:;" class="has-arrow">
              <div class="parent-icon p-1"><i class="lni lni-folder"></i>
              </div>
              <div class="menu-title">Form</div>
            </a>
            <ul>
              <li class="">
                  <a href="javascript:;" class="has-arrow d-flex align-items-center">
                    <i class="material-icons-outlined me-2">arrow_right</i>
                    <span>Master Data</span>
                  </a>
                  <ul>
                      <li>
                        <a href="{{ Route('masterForm.index') }}" class="d-flex align-items-center">
                          <i class="material-icons-outlined me-2">arrow_right</i>
                          <span>Master Form</span>
                        </a>
                      </li>
                      <li>
                        <a href="{{ Route('nomorForm.index') }}" class="d-flex align-items-center">
                          <i class="material-icons-outlined me-2">arrow_right</i>
                          <span>Nomor Form</span>
                        </a>
                      </li>
                  </ul>
              </li>
              <li class="{{ request()->is('transaksi-form/*/edit', 'transaksi-form/create') ? 'mm-active' : '' }}">
                <a href="{{ Route('transaksi-form.index') }}"><i class="material-icons-outlined">arrow_right</i>
                  Transaksi Form</a>
              </li>
            </ul>
          </li>
        @endcan
        @can('menu.memo')
          <li>
            <a href="javascript:;" class="has-arrow">
              <div class="parent-icon p-1"><i class="lni lni-briefcase"></i>
              </div>
              <div class="menu-title">Memo</div>
            </a>
            <ul>
 		@if (Auth::user()->hasRole('super-admin'))
                    <li class="">
                  <a href="javascript:;" class="has-arrow d-flex align-items-center">
                    <i class="material-icons-outlined me-2">arrow_right</i>
                    <span>Master Data</span>
                  </a>
                  <ul>
                      <li>
                        <a href="{{ Route('unitKerja.index') }}" class="d-flex align-items-center">
                          <i class="material-icons-outlined me-2">arrow_right</i>
                          <span>Unit Kerja</span>
                        </a>
                      </li>
                      <li>
                        <a href="{{ Route('klasifikasi.memo.index') }}" class="d-flex align-items-center">
                          <i class="material-icons-outlined me-2">arrow_right</i>
                          <span>Klasifikasi</span>
                        </a>
                      </li>
                  </ul>
              </li>
                @endif

              
              <li class="{{ request()->is('memo/transaksi-memo/*/edit', 'memo/transaksi-memo/create') ? 'mm-active' : '' }}">
                <a href="{{ Route('transaksiMemo.index') }}"><i class="material-icons-outlined">arrow_right</i>
                  Memo</a>
              </li>
            </ul>
          </li>
        @endcan
	@can('menu.layanan-divisi')
          <li>
            <a class="has-arrow" href="javascript:;">
              <div class="parent-icon"><i class="fadeIn animated bx bx-donate-blood"></i>
              </div>
              <div class="menu-title">Layanan Divisi</div>
            </a>
            <ul>
              <li><a class="has-arrow" href="javascript:;"><i class="material-icons-outlined">arrow_right</i>Divisi Umum</a>
                <ul>
                  <li><a href="{{ Route('transactionMeetingRoom.index.user') }}"><i
                        class="material-icons-outlined">arrow_right</i>Pemesanan Ruangan Rapat</a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
        @endcan

        @can('menu.signature')
          <li>
            <a href="{{ route('signature.index') }}">
              <div class="parent-icon"><i class="material-icons-outlined">person</i>
              </div>
              <div class="menu-title">Tanda Tangan</div>
            </a>
          </li>
        @endcan

        @if (Auth::user()->hasRole('super-admin'))
          <li>
            <a href="javascript:;" class="has-arrow">
              <div class="parent-icon p-1">
                <i class="lni lni-shield"></i>
              </div>
              <div class="menu-title">Management Access</div>
            </a>
            <ul>
              <li><a href="{{ route('user.index') }}"><i class="material-icons-outlined">arrow_right</i>User</a>
              </li>
              <li>
                <a href="{{ route('role.index') }}"><i class="material-icons-outlined">arrow_right</i>Role</a>
              </li>
              <li>
                <a href="{{ route('permission.index') }}"><i
                    class="material-icons-outlined">arrow_right</i>Permission</a>
              </li>
              <li>
                <a href="{{ route('route.index') }}"><i class="material-icons-outlined">arrow_right</i>Route</a>
              </li>

            </ul>
          </li>
        @endif

      </ul>
      <!--end navigation-->
    </div>
  </aside>
