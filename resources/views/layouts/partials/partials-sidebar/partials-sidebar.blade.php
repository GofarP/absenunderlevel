<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Lava Cheese</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    @if (Auth::user()->karyawan->first()?->jabatan?->nama == 'Administrator')
        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            Karyawan
        </div>
        <li class="nav-item {{ request()->is('karyawan*') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseKaryawan"
                aria-expanded="true" aria-controls="collapseKaryawan">
                <i class="fas fa-fw fa-user"></i>
                <span>Karyawan</span>
            </a>
            <div id="collapseKaryawan" class="collapse {{ request()->is('karyawan*') ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Data Karyawan:</h6>
                    <a class="collapse-item {{ request()->is('karyawan*') ? 'active' : '' }}"
                        href="{{ route('karyawan.index') }}">Data Karyawan</a>
                </div>
            </div>
        </li>

        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            Jabatan
        </div>
        <li class="nav-item {{ request()->is('jabatan*') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseJabatan"
                aria-expanded="true" aria-controls="collapseJabatan">
                <i class="fas fa-fw fa-user"></i>
                <span>Jabatan</span>
            </a>
            <div id="collapseJabatan" class="collapse {{ request()->is('jabatan*') ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Data Jabatan:</h6>
                    <a class="collapse-item {{ request()->is('jabatan*') ? 'active' : '' }}"
                        href="{{ route('jabatan.index') }}">Data Jabatan</a>
                </div>
            </div>
        </li>
        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            Cabang
        </div>
        <li class="nav-item {{ request()->is('cabang*') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCabang"
                aria-expanded="true" aria-controls="collapseJabatan">
                <i class="fas fa-fw fa-user"></i>
                <span>Cabang</span>
            </a>
            <div id="collapseCabang" class="collapse {{ request()->is('cabang*') ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Data Cabang:</h6>
                    <a class="collapse-item {{ request()->is('cabang*') ? 'active' : '' }}"
                        href="{{ route('cabang.index') }}">Data Cabang</a>
                </div>
            </div>
        </li>

        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            Shift
        </div>
        <li class="nav-item {{ request()->is('shift*') ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseShift"
                aria-expanded="true" aria-controls="collapseShift">
                <i class="fas fa-fw fa-user"></i>
                <span>Shift</span>
            </a>
            <div id="collapseShift" class="collapse {{ request()->is('shift*') ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Data Shift:</h6>
                    <a class="collapse-item {{ request()->is('shift*') ? 'active' : '' }}"
                        href="{{ route('shift.index') }}">Data Shift</a>
                </div>
            </div>
        </li>

        <hr class="sidebar-divider">


    @endif


    <div class="sidebar-heading">
        Absensi
    </div>
    <li class="nav-item {{ request()->is('absensi*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAbsensi"
            aria-expanded="true" aria-controls="collapseAbsensi">
            <i class="fas fa-fw fa-user"></i>
            <span>Absensi</span>
        </a>
        <div id="collapseAbsensi" class="collapse {{ request()->is('absensi*') ? 'show' : '' }}"
            aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"> Absensi:</h6>
                @if (Auth::user()->karyawan->first()?->jabatan->nama == 'Karyawan' || Auth::user()->karyawan->first()?->jabatan->nama == 'Manager' )
                    <a class="collapse-item {{ request()->is('absensi*') ? 'active' : '' }}"
                        href="{{ route('absensi.index') }}">Absensi</a>
                @elseif (Auth::user()->karyawan->first()?->jabatan->nama == 'Administrator' || Auth::user()->karyawan->first()?->jabatan->nama == 'Manager' )
                    <a class="collapse-item {{ request()->is('absensi/laporanabsensi*') ? 'active' : '' }}"
                        href="{{ route('absensi.laporanabsensi') }}">Laporan Absensi</a>
                        <a class="collapse-item {{ request()->is('absensi/statusabsensi*') ? 'active' : '' }}"
                            href="{{ route('statusabsensi.index') }}">Status Absensi</a>
                @endif
            </div>
        </div>
    </li>


</ul>
