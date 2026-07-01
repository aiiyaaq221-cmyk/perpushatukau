<aside class="sidebar" id="sidebar">
    <div class="logo-section">
        <img src="{{ asset('img/perpus.png') }}" alt="Logo">
        <div class="logo-text">
            <h5>Perpustakaan Hatukau</h5>
            <small>Negeri Batumerah</small>
        </div>
    </div>

    <ul class="menu">
        <li>
            <a href="{{ route('dashboard') }}"
               class="{{ request()->routeIs('dashboard') ? 'active-menu' : '' }}">
                <div class="menu-left">
                    <i class="fas fa-chart-pie"></i>
                    <span>Dashboard</span>
                </div>
            </a>
        </li>

        <li class="has-submenu {{ request()->routeIs('master.*') ? 'active-parent' : '' }}"
            data-menu="master">
            <button type="button" class="parent-link">
                <div class="menu-left">
                    <i class="fas fa-folder-open"></i>
                    <span>Master Data</span>
                </div>

                <span class="arrow">
                    <i class="fas fa-chevron-down"></i>
                </span>
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
                

        <li class="has-submenu {{ request()->routeIs('transaksi.*') ? 'active-parent' : '' }}"
            data-menu="transaksi">
            <button type="button" class="parent-link">
                <div class="menu-left">
                    <i class="fas fa-repeat"></i>
                    <span>Transaksi</span>
                </div>
                <span class="arrow">
                    <i class="fas fa-chevron-down"></i>
                </span>
            </button>

            <ul class="submenu">
                <li>
                    <a href="{{ route('transaksi.peminjaman.index') }}"
                       class="{{ request()->routeIs('transaksi.peminjaman.*') ? 'active-menu' : '' }}">
                        <i class="fas fa-book-reader"></i>
                        <span>Peminjaman Buku</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('transaksi.pengembalian.index') }}"
                       class="{{ request()->routeIs('transaksi.pengembalian.*') ? 'active-menu' : '' }}">
                        <i class="fas fa-undo"></i>
                        <span>Pengembalian Buku</span>
                    </a>
                </li>
            </ul>
        </li>


        <li>
            <a href="{{ route('pengunjung.index') }}"
               class="{{ request()->routeIs('pengunjung.*') ? 'active-menu' : '' }}">
                <div class="menu-left">
                    <i class="fas fa-address-book"></i>
                    <span>Buku Tamu</span>
                </div>
            </a>
        </li>



        <li class="has-submenu {{ request()->routeIs('laporan.*') ? 'active-parent' : '' }}"
            data-menu="laporan">
            <button type="button" class="parent-link">
                <div class="menu-left">
                    <i class="fas fa-chart-bar"></i>
                    <span>Laporan</span>
                </div>
                <span class="arrow">
                    <i class="fas fa-chevron-down"></i>
                </span>
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
                        <span>Laporan Peminjaman</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('laporan.pengembalian') }}"
                       class="{{ request()->routeIs('laporan.pengembalian') ? 'active-menu' : '' }}">
                        <i class="fas fa-undo-alt"></i>
                        <span>Laporan Pengembalian</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('laporan.pengunjung') }}"
                       class="{{ request()->routeIs('laporan.pengunjung') ? 'active-menu' : '' }}">
                       <i class="fas fa-user-friends"></i>
                        <span>Laporan Pengunjung</span>
                    </a>
                </li>
            </ul>
        </li>

        {{-- ===========================
            PROFIL ADMIN
        ============================ --}}
        <li>
            <a href="#">
                <div class="menu-left">
                    <i class="fas fa-user-cog"></i>
                    <span>Profil Admin</span>
                </div>
            </a>
        </li>
    </ul>


    {{-- ===========================================
        LOGOUT
    ============================================ --}}
    <div class="logout">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>


{{-- ===========================================
    SIDEBAR RESIZER
=========================================== --}}
<div class="sidebar-resizer" id="sidebarResizer"></div>