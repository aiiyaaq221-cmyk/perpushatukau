
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg sticky-top navbar-custom py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-3" href="#">
                <div class="rounded-3 d-flex align-items-center justify-content-center text-white" style="width: 42px; height: 42px; background: var(--primary-gradient);">
                    <i class="bi bi-book-half fs-5"></i>
                </div>
                <div>
                    <span class="fs-6 fw-bold d-block text-dark leading-tight">Perpustakaan Hatukau</span>
                    <small class="text-muted fw-normal" style="font-size: 12px;">Negeri Batumerah</small>
                </div>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto gap-lg-3">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('welcome') ? 'active' : '' }}" href="{{ route('welcome') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}"  href="{{ route('books.index') }}">books</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                </ul>

            <div class="d-flex align-items-center gap-2">

    <a href="{{ route('login') }}"
       class="btn btn-outline-primary rounded-pill px-4 py-2 fw-semibold">

        <i class="bi bi-box-arrow-in-right me-2"></i>
        Login

    </a>

    <a href="{{ route('register') }}"
       class="btn btn-primary rounded-pill px-4 py-2 fw-semibold shadow-sm">

        <i class="bi bi-person-plus-fill me-2"></i>
        Daftar Anggota

    </a>

</div>
                <!-- <a href="{{ route('login') }}" class="btn  rounded-pill px-4 fw-bold ms-lg-2">Login</a>
                <a href="{{ route('register') }}" class="btn rounded-pill px-3 fw-bold ms-lg-3">Daftar Anggota</a> -->
            </div>
        </div>
    </nav>