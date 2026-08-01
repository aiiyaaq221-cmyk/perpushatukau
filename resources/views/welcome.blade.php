<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perpustakaan Hatukau Negeri Batumerah</title>

    <!-- Google Fonts: Plus Jakarta Sans (Sangat Modern & Clean) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">

</head>


<body>

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
                    <li class="nav-item"><a class="nav-link active" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#books">Collection</a></li>
                    <li class="nav-item"><a class="nav-link" href="#guide">Guide</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                </ul>
                
                <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-pill px-4 fw-bold ms-lg-3">Login</a>
            </div>
        </div>
    </nav>

    <div class="container py-4" id="home">

        <!-- HERO SECTION -->
        <section class="my-3">
            <div class="hero-section p-4 p-lg-5 overflow-hidden position-relative">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill bg-white border border-primary-subtle text-primary mb-3 shadow-sm">
                            <i class="bi bi-stars"></i>
                            <span class="small fw-semibold">Modern Digital Library Ecosystem</span>
                        </div>

                        <h1 class="display-5 fw-extrabold mb-3 leading-tight">
                            Explore Knowledge<br>
                            Through <span class="text-gradient">Our Digital Library</span>
                        </h1>
                        
                        <p class="text-muted fs-6 mb-4 pe-lg-4" style="line-height: 1.7;">
                            Akses katalog buku fisik dan koleksi digital dengan sistem pelayanan pintar, cepat, serta suasana belajar yang futuristik.
                        </p>

                        <div class="d-flex flex-wrap gap-3 align-items-center">
                            <a href="#books" class="btn btn-primary-gradient shadow-sm">
                                <i class="bi bi-compass me-1"></i> Explore Collection
                            </a>
                            <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-semibold">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Login
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-6 text-center">
                        <div class="p-2">
                            <img src="{{ asset('img/landing1.jpeg') }}" alt="3D Library Illustration" class="img-fluid rounded-4 w-100 object-fit-cover shadow-sm" style="max-height: 340px;">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- STATISTICS SECTION -->
        <section class="my-5">
            <h4 class="fw-bold text-center mb-4">Ringkasan Perpustakaan</h4>
            <div class="row g-4">
                <div class="col-6 col-md-3">
                    <div class="modern-card p-4">
                        <span class="text-muted small fw-medium">Total Buku</span>
                        <h2 class="fw-bold mb-0 mt-2 text-dark"> {{ $jumlahBuku }}</h2>
                    </div>
                </div>                    
                <div class="col-6 col-md-3">
                    <div class="modern-card p-4">
                        <span class="text-muted small fw-medium">Anggota Aktif</span>
                        <h2 class="fw-bold mb-0 mt-2 text-dark">{{ number_format($stats['members'] ?? 25586) }}</h2>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="modern-card p-4">
                        <span class="text-muted small fw-medium">Kategori</span>
                        <h2 class="fw-bold mb-0 mt-2 text-dark">{{ number_format($stats['categories'] ?? 3875) }}</h2>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="modern-card p-4">
                        <span class="text-muted small fw-medium">Total Peminjaman</span>
                        <h2 class="fw-bold mb-0 mt-2 text-dark">{{ number_format($stats['borrowings'] ?? 1044) }}</h2>
                    </div>
                </div>
            </div>
        </section>

        <!-- FEATURED BOOKS SECTION -->
        <section class="my-5" id="books">
            <div class="position-relative text-center mb-4">
                <h4 class="fw-bold text-center mb-2">Featured Books</h4>
                <p class="text-muted small mb-0"> Rekomendasi buku populer minggu ini </p>
                <a href="#" class="btn btn-sm btn-outline-secondary rounded-pill px-3 position-absolute top-50 end-0 translate-middle-y"> View All </a>
            </div>

            <div class="row g-4">
                @php
                    $sampleBooks = isset($featuredBooks) && count($featuredBooks) > 0 ? $featuredBooks : [
                        ['title' => 'The Book Books in...', 'author' => 'John Somen', 'bg' => 'bg-danger'],
                        ['title' => 'The Book Books', 'author' => 'John Somen', 'bg' => 'bg-warning'],
                        ['title' => 'The Book of Startm...', 'author' => 'Jean Stams', 'bg' => 'bg-info'],
                        ['title' => 'The Book-book Dr!...', 'author' => 'Jem Ransxn', 'bg' => 'bg-dark']
                    ];
                @endphp

                @foreach($sampleBooks as $book)
                    <div class="col-6 col-md-3">
                        <div class="modern-card p-3 h-100 d-flex flex-column justify-content-between">
                            <div>
                                <div class="book-cover-wrapper mb-3">
                                    <div class="book-badge {{ $book['bg'] ?? 'bg-primary' }}">
                                        {{ $book['title'] ?? $book->judul }}
                                    </div>
                                </div>
                                <h6 class="fw-bold mb-1 text-truncate">{{ $book['title'] ?? $book->judul }}</h6>
                                <p class="text-muted small mb-3">by {{ $book['author'] ?? $book->penulis }}</p>
                            </div>
                            <button class="btn btn-light text-primary fw-semibold w-100 btn-sm py-2 rounded-3">View Details</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- WHY CHOOSE US -->
        <section class="my-5">
            <h4 class="fw-bold text-center mb-4">Why Choose Us</h4>
            <div class="row g-4">
                <div class="col-6 col-md-3">
                    <div class="modern-card p-4 h-100">
                        <div class="icon-box mb-3"><i class="bi bi-bookshelf"></i></div>
                        <h6 class="fw-bold mb-2">Extensive Collection</h6>
                        <p class="text-muted small mb-0">Koleksi buku terupdate dari berbagai bidang keilmuan.</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="modern-card p-4 h-100">
                        <div class="icon-box mb-3"><i class="bi bi-search"></i></div>
                        <h6 class="fw-bold mb-2">Easy Search</h6>
                        <p class="text-muted small mb-0">Cari buku favorit dengan cepat lewat katalog digital.</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="modern-card p-4 h-100">
                        <div class="icon-box mb-3"><i class="bi bi-journal-bookmark"></i></div>
                        <h6 class="fw-bold mb-2">Online Catalog</h6>
                        <p class="text-muted small mb-0">Cek ketersediaan buku kapan saja & dari mana saja.</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="modern-card p-4 h-100">
                        <div class="icon-box mb-3"><i class="bi bi-lightning-charge"></i></div>
                        <h6 class="fw-bold mb-2">Fast Service</h6>
                        <p class="text-muted small mb-0">Proses peminjaman & pengembalian buku yang praktis.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- FEATURES / ATMOSPHERE SECTION -->
        <section class="my-5">
            <div class="modern-card p-4 p-md-5">
                <div class="row align-items-center g-4">
                    <div class="col-md-6">
                        <img src="{{ asset('img/gedung.jpeg') }}" alt="Learning Atmosphere" class="img-fluid rounded-4 w-100 object-fit-cover" style="max-height: 300px;">
                    </div>
                    <div class="col-md-6 ps-md-4">
                        <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-semibold mb-2">Comfortable Workspace</span>
                        <h3 class="fw-bold mb-3">Futuristic Learning Atmosphere</h3>
                        <p class="text-muted mb-4" style="line-height: 1.7;">
                            Nikmati fasilitas modern, area baca ber-AC yang nyaman, akses Wi-Fi berkecepatan tinggi, serta suasana tenang yang mendukung produktivitas belajar Anda.
                        </p>
                        <div class="d-flex align-items-center gap-3 bg-light p-3 rounded-3">
                            <i class="bi bi-laptop fs-3 text-primary"></i>
                            <span class="text-muted small">Dilengkapi area kerja digital untuk laptop & ruang baca privat.</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- BORROWING PROCESS -->
        <section class="my-5 text-center" id="guide">
            <h4 class="fw-bold mb-2">Proses Peminjaman</h4>
            <p class="text-muted small mb-4">4 langkah mudah meminjam buku di perpustakaan kami</p>

            <div class="row g-4">
                <div class="col-6 col-md-3">
                    <div class="modern-card p-4 text-center h-100">
                        <div class="icon-box mx-auto mb-3"><i class="bi bi-search"></i></div>
                        <h6 class="fw-bold mb-1">1. Browse Books</h6>
                        <span class="text-muted small">Cari & pilih buku</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="modern-card p-4 text-center h-100">
                        <div class="icon-box mx-auto mb-3"><i class="bi bi-inbox"></i></div>
                        <h6 class="fw-bold mb-1">2. Request</h6>
                        <span class="text-muted small">Ajukan peminjaman</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="modern-card p-4 text-center h-100">
                        <div class="icon-box mx-auto mb-3"><i class="bi bi-building"></i></div>
                        <h6 class="fw-bold mb-1">3. Visit Us</h6>
                        <span class="text-muted small">Datang ke perpustakaan</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="modern-card p-4 text-center h-100">
                        <div class="icon-box mx-auto mb-3"><i class="bi bi-check-circle"></i></div>
                        <h6 class="fw-bold mb-1">4. Pick Up</h6>
                        <span class="text-muted small">Ambil & selamat membaca</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- ABOUT SECTION -->
        <section class="my-5" id="about">
            <div class="row align-items-center g-4">
                <div class="col-md-5">
                    <div class="modern-card p-3">
                        <img src="{{ asset('img/perpus.png') }}" alt="Library Interior" class="img-fluid rounded-4 w-100">
                    </div>
                </div>
                <div class="col-md-7 ps-md-4">
                    <h4 class="fw-bold mb-3">About Perpustakaan Hatukau</h4>
                    <p class="text-muted mb-3" style="line-height: 1.7;">
                        Perpustakaan Hatukau Negeri Batumerah berkomitmen untuk menyediakan sarana literasi modern yang lengkap dan mudah diakses oleh seluruh lapisan masyarakat. 
                    </p>
                    <p class="text-muted mb-0" style="line-height: 1.7;">
                        Kami menyediakan ribuan koleksi literatur berkualitas, ruang baca terintegrasi, dan layanan peminjaman berbasis digital untuk mempermudah pengalaman belajar masyarakat Kota Ambon.
                    </p>
                </div>
            </div>
        </section>

        <!-- CONTACT & MAPS SECTION -->
        <section class="my-5" id="contact">
            <h4 class="fw-bold text-center mb-4">Get in Touch</h4>
            <div class="row g-4 align-items-center">
                <div class="col-md-5">
                    <div class="modern-card p-4 d-flex flex-column gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-box"><i class="bi bi-geo-alt"></i></div>
                            <div>
                                <h6 class="fw-bold mb-0">Location</h6>
                                <p class="text-muted small mb-0">Jl. Hatukau, Negeri Batumerah, Kota Ambon, Maluku</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-box"><i class="bi bi-telephone"></i></div>
                            <div>
                                <h6 class="fw-bold mb-0">Phone</h6>
                                <p class="text-muted small mb-0">+62 812-442-8788</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-box"><i class="bi bi-envelope"></i></div>
                            <div>
                                <h6 class="fw-bold mb-0">Email</h6>
                                <p class="text-muted small mb-0">hatukau.library@gmail.com</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-box"><i class="bi bi-clock"></i></div>
                            <div>
                                <h6 class="fw-bold mb-0">Opening Hours</h6>
                                <p class="text-muted small mb-0">Senin - Sabtu: 08:00 - 16:00 WIT</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-7">
                    <a href="https://maps.app.goo.gl/y9wtoYq1NE1LQA4w7" target="_blank" class="d-block text-decoration-none">
                        <div class="modern-card p-2">
                            <div class="map-wrapper">
                                <iframe
                                    src="https://www.google.com/maps?q=-3.6809868,128.1919078&z=18&output=embed"
                                    width="100%"
                                    height="100%"
                                    style="border:0; pointer-events:none;"
                                    loading="lazy">
                                </iframe>
                                <div class="map-badge">
                                    <i class="bi bi-geo-alt-fill me-1"></i> Buka di Google Maps
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </section>

    </div>

    <!-- FOOTER -->
    <footer class="bg-white border-top py-5 mt-5">
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="rounded-3 d-flex align-items-center justify-content-center text-white" style="width: 32px; height: 32px; background: var(--primary-gradient);">
                            <i class="bi bi-book-half fs-6"></i>
                        </div>
                        <span class="fw-bold text-dark fs-6">Perpustakaan Hatukau</span>
                    </div>
                    <p class="text-muted small" style="max-width: 300px;">
                        Pusat literasi digital modern untuk masyarakat Negeri Batumerah dan sekitarnya.
                    </p>
                </div>
                <div class="col-6 col-md-2">
                    <h6 class="fw-bold mb-3 text-dark">Quick Links</h6>
                    <ul class="list-unstyled text-muted small d-flex flex-column gap-2">
                        <li><a href="#home" class="text-decoration-none text-muted">Home</a></li>
                        <li><a href="#about" class="text-decoration-none text-muted">Tentang Kami</a></li>
                        <li><a href="#books" class="text-decoration-none text-muted">Collection</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md-2">
                    <h6 class="fw-bold mb-3 text-dark">Services</h6>
                    <ul class="list-unstyled text-muted small d-flex flex-column gap-2">
                        <li><a href="#guide" class="text-decoration-none text-muted">Panduan Peminjaman</a></li>
                        <li><a href="{{ route('login') }}" class="text-decoration-none text-muted">Login Anggota</a></li>
                        <li><a href="#contact" class="text-decoration-none text-muted">Support</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="fw-bold mb-3 text-dark">Newsletter</h6>
                    <p class="text-muted small">Dapatkan informasi buku terbaru langsung ke email Anda.</p>
                    <div class="input-group">
                        <input type="email" class="form-control rounded-start-pill ps-3" placeholder="Masukkan email...">
                        <button class="btn btn-primary-gradient rounded-end-pill px-4" type="button">Subscribe</button>
                    </div>
                </div>
            </div>

            <hr class="border-light">

            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center text-muted small pt-2 gap-2">
                <p class="mb-0">&copy; {{ date('Y') }} Perpustakaan Hatukau. All rights reserved.</p>
                <span>Negeri Batumerah, Kota Ambon</span>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>