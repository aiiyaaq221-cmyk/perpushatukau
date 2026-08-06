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