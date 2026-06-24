<aside class="sidebar" id="sidebar">
    <div class="logo-section">
        <img src="{{ asset('img/perpus.png') }}" alt="Logo">
        <div>
            <h5>Perpustakaan Hatukau</h5>
            <small>Negeri Batumerah</small>
        </div>
    </div>

    <ul class="menu">
        <li>
            <a href="{{ route('dashboard') }}"
               class="{{ request()->routeIs('dashboard') ? 'active-menu' : '' }}">
                📊 Dashboard
            </a>
        </li>

        {{-- MASTER DATA --}}
        <li class="has-submenu {{ request()->routeIs('master.*') ? 'active-parent' : '' }}">

            <a href="#">
                📁 Master Data
                <span class="arrow">▼</span>
            </a>

            <ul class="submenu">

                <li>
                    <a href="{{ route('master.buku.index') }}"
                       class="{{ request()->routeIs('master.buku.*') ? 'active-menu' : '' }}">
                        📚 Data Buku
                    </a>
                </li>

                <li>
                    <a href="{{ route('master.kategori.index') }}"
                       class="{{ request()->routeIs('master.kategori.*') ? 'active-menu' : '' }}">
                        🏷️ Kategori Buku
                    </a>
                </li>

                <li>
                    <a href="{{ route('master.anggota.index') }}"
                       class="{{ request()->routeIs('master.anggota.*') ? 'active-menu' : '' }}">
                        👥 Data Anggota
                    </a>
                </li>

            </ul>

        </li>

        {{-- TRANSAKSI --}}
        <li class="has-submenu {{ request()->routeIs('transaksi.*') ? 'active-parent' : '' }}">

            <a href="#">
                🔄 Transaksi
                <span class="arrow">▼</span>
            </a>

            <ul class="submenu">

                <li>
                    <a href="{{ route('transaksi.peminjaman.index') }}"
                       class="{{ request()->routeIs('transaksi.peminjaman.*') ? 'active-menu' : '' }}">
                        📖 Peminjaman Buku
                    </a>
                </li>

                <li>
                    <a href="{{ route('transaksi.pengembalian.index') }}"
                       class="{{ request()->routeIs('transaksi.pengembalian.*') ? 'active-menu' : '' }}">
                        📕 Pengembalian Buku
                    </a>
                </li>

            </ul>

        </li>

        <li>
            <a href="{{ route('pengunjung.index') }}"
               class="{{ request()->routeIs('pengunjung.*') ? 'active-menu' : '' }}">
                📝 Buku Tamu
            </a>
        </li>

        {{-- LAPORAN --}}
        <li class="has-submenu {{ request()->routeIs('laporan.*') ? 'active-parent' : '' }}">

            <a href="#">
                📊 Laporan
                <span class="arrow">▼</span>
            </a>

            <ul class="submenu">

                <li>
                    <a href="{{ route('laporan.buku') }}"
                       class="{{ request()->routeIs('laporan.buku') ? 'active-menu' : '' }}">
                        📚 Laporan Buku
                    </a>
                </li>

                <li>
                    <a href="{{ route('laporan.anggota') }}"
                       class="{{ request()->routeIs('laporan.anggota') ? 'active-menu' : '' }}">
                        👥 Laporan Anggota
                    </a>
                </li>

                <li>
                    <a href="{{ route('laporan.peminjaman') }}"
                       class="{{ request()->routeIs('laporan.peminjaman') ? 'active-menu' : '' }}">
                        📖 Laporan Peminjaman
                    </a>
                </li>

                <li>
                    <a href="{{ route('laporan.pengembalian') }}"
                       class="{{ request()->routeIs('laporan.pengembalian') ? 'active-menu' : '' }}">
                        📕 Laporan Pengembalian
                    </a>
                </li>

                <li>
                    <a href="{{ route('laporan.pengunjung') }}"
                       class="{{ request()->routeIs('laporan.pengunjung') ? 'active-menu' : '' }}">
                        📝 Laporan Pengunjung
                    </a>
                </li>

            </ul>

        </li>

        <li>
            <a href="#">
                ⚙️ Profil Admin
            </a>
        </li>

    </ul>

    <div class="logout">

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="logout-btn">
                Logout
            </button>

        </form>

    </div>

</aside>

<div class="sidebar-resizer" id="sidebarResizer"></div>