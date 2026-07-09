<aside class="sidebar" id="sidebar">

    {{-- ===========================
        SIDEBAR HEADER
    ============================ --}}
    <div class="sidebar-header">

        <div class="brand">

            <img src="{{ asset('img/perpus.png') }}" alt="Logo">

            <div class="brand-text">

                <h5>Perpustakaan Hatukau </h5>

                <small>Batumerah</small>

            </div>
            <button id="sidebarToggle"
                class="collapse-btn"
                type="button">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>


    {{-- ===========================
        MENU
    ============================ --}}
    <div class="sidebar-menu">

        <ul>

            {{-- Dashboard --}}
            <li>

                <a href="{{ route('dashboard') }}"
                   class="{{ request()->routeIs('dashboard') ? 'active-menu' : '' }}">

                    <i class="fas fa-chart-pie"></i>

                    <span>Dashboard</span>

                </a>

            </li>



            {{-- MASTER DATA --}}
             

            <li class="has-submenu {{ request()->routeIs('master.*') ? 'active-parent' : '' }}"
                data-menu="master">

                <button class="parent-link">

                    <div class="menu-item">

                        <i class="fas fa-folder-open"></i>

                        <span>Master Data</span>

                    </div>

                    <i class="fas fa-chevron-down arrow"></i>

                </button>

                <ul class="submenu">

                    <li>

                        <a href="{{ route('master.buku.index') }}"
                           class="{{ request()->routeIs('master.buku.*') ? 'active-menu' : '' }}">

                            <i class="fas fa-book"></i>

                            <span>Data Buku</span>

                        </a>

                    </li>

                    <li>

                        <a href="{{ route('master.kategori.index') }}"
                           class="{{ request()->routeIs('master.kategori.*') ? 'active-menu' : '' }}">

                            <i class="fas fa-tags"></i>

                            <span>Kategori Buku</span>

                        </a>

                    </li>

                    <li>

                        <a href="{{ route('master.anggota.index') }}"
                           class="{{ request()->routeIs('master.anggota.*') ? 'active-menu' : '' }}">

                            <i class="fas fa-users"></i>

                            <span>Data Anggota</span>

                        </a>

                    </li>

                </ul>

            </li>



            {{-- TRANSAKSI --}}
             

            <li class="has-submenu {{ request()->routeIs('transaksi.*') ? 'active-parent' : '' }}"
                data-menu="transaksi">

                <button class="parent-link">

                    <div class="menu-item">

                        <i class="fas fa-repeat"></i>

                        <span>Transaksi</span>

                    </div>

                    <i class="fas fa-chevron-down arrow"></i>

                </button>

                <ul class="submenu">

                    <li>

                        <a href="{{ route('transaksi.peminjaman.index') }}"
                           class="{{ request()->routeIs('transaksi.peminjaman.*') ? 'active-menu' : '' }}">

                            <i class="fas fa-book-reader"></i>

                            <span>Peminjaman</span>

                        </a>

                    </li>

                    <li>

                        <a href="{{ route('transaksi.pengembalian.index') }}"
                           class="{{ request()->routeIs('transaksi.pengembalian.*') ? 'active-menu' : '' }}">

                            <i class="fas fa-undo"></i>

                            <span>Pengembalian</span>

                        </a>

                    </li>

                </ul>

            </li>



            {{-- BUKU TAMU --}}
            <li>

                <a href="{{ route('pengunjung.index') }}"
                   class="{{ request()->routeIs('pengunjung.*') ? 'active-menu' : '' }}">

                    <i class="fas fa-address-book"></i>

                    <span>Buku Tamu</span>

                </a>

            </li>



            {{-- LAPORAN --}}
            
            <li class="has-submenu {{ request()->routeIs('laporan.*') ? 'active-parent' : '' }}"
                data-menu="laporan">

                <button class="parent-link">

                    <div class="menu-item">

                        <i class="fas fa-chart-line"></i>

                        <span>Laporan</span>

                    </div>

                    <i class="fas fa-chevron-down arrow"></i>

                </button>

                <ul class="submenu">
                    <li>
                        <a href="{{ route('laporan.buku') }}"
                           class="{{ request()->routeIs('laporan.buku') ? 'active-menu' : '' }}">
                            <i class="fas fa-book"></i>
                            <span>Laporan Buku</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('laporan.anggota') }}"
                           class="{{ request()->routeIs('laporan.anggota') ? 'active-menu' : '' }}">
                            <i class="fas fa-users"></i>
                            <span>Laporan Anggota</span>
                        </a>
                    </li>

                    <li>

                        <a href="{{ route('laporan.peminjaman') }}"
                           class="{{ request()->routeIs('laporan.peminjaman') ? 'active-menu' : '' }}">
                            <i class="fas fa-book-reader"></i>
                            <span>Peminjaman</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('laporan.pengembalian') }}"
                           class="{{ request()->routeIs('laporan.pengembalian') ? 'active-menu' : '' }}">
                            <i class="fas fa-undo"></i>
                            <span>Pengembalian</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('laporan.pengunjung') }}"
                           class="{{ request()->routeIs('laporan.pengunjung') ? 'active-menu' : '' }}">
                            <i class="fas fa-user-friends"></i>
                            <span>Pengunjung</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>

    <div class="sidebar-profile">
        <a href="{{ route('profil.index') }}" class="profile-card-sidebar">
            <div class="profile-left">
                @if(Auth::user()->foto)
                    <img src="{{ asset('storage/'.Auth::user()->foto) }}"
                        class="profile-sidebar-img">
                @else
                    <div class="profile-sidebar-placeholder">
                        {{ strtoupper(substr(Auth::user()->name,0,1)) }}
                    </div>
                @endif
                <div class="profile-sidebar-info">
                    <h6>{{ Auth::user()->name }}</h6>
                    <small>Admin</small>
                </div>
            </div>
            <i class="fas fa-chevron-right profile-arrow"></i>
        </a>
</div>

    {{-- ===========================
        FOOTER
    ============================ --}}
    <div class="sidebar-footer">

        <form method="POST" action="{{ route('logout') }}">

            @csrf

            <button class="logout-btn">

                <i class="fas fa-sign-out-alt"></i>

                <span>Logout</span>

            </button>

        </form>

    </div>

</aside>