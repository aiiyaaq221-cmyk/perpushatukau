<!-- SEARCH BOOK SECTION -->
        <section class="py-5">
            <div class="container">

                <div class="text-center mb-5">
                    <h2 class="fw-bold mb-3">
                        Temukan Buku Favorit Anda
                    </h2>

                    <p class="text-muted mx-auto search-description">
                        Cari koleksi buku berdasarkan <strong>judul</strong> atau
                        <strong>pengarang</strong> dengan cepat dan mudah.
                    </p>
                </div>

                <form id="searchForm" action="{{ route('welcome') }}" method="GET">
                    <div class="search-container shadow-sm rounded-pill p-2">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-0">
                                <i class="bi bi-search"></i>
                            </span>

                            <input type="text" id="searchBook"
                                name="search" class="form-control border-0 shadow-none"
                                placeholder="Cari judul buku atau nama pengarang..."
                                value="{{ request('search') }}" autocomplete="off">

                            <button class="btn btn-primary rounded-pill px-4" type="submit"> Cari </button>
                        </div>
                    </div>
                </form>
            </div>
        </section>