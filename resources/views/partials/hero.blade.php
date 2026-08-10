<!-- HERO SECTION -->
<div class="container py-4" id="home">
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
                    <a href="{{ route('books.index') }}" class="btn btn-primary-gradient shadow-sm">
                        <i class="bi bi-compass me-1"></i> Explore Collection
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