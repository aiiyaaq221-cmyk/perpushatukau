@if(request()->filled('search'))
<div id="searchAlert" class="alert alert-success border-0 rounded-4 shadow-sm mb-4 d-flex justify-content-between align-items-center">
    <div>
        <i class="bi bi-check-circle-fill me-2"></i>
        Pencarian berhasil, ditemukan
        <strong>{{ $books->count() }}</strong>
        buku.
    </div>

    <button type="button" class="btn-close" aria-label="Close"  onclick="closeSearchAlert()"> </button>
</div>

@endif


<div class="row g-4">

@forelse($books as $book)

<div class="col-6 col-md-3">

    <div class="modern-card p-3 h-100">

        <div class="book-cover-wrapper mb-3">

            @if($book->cover)

                <img src="{{ asset('storage/'.$book->cover) }}"
                    class="img-fluid rounded-3"
                    style="
                    height:220px;
                    width:100%;
                    object-fit:cover;
                    ">

            @else

                <div class="book-badge bg-secondary">

                    Tidak Ada Cover

                </div>

            @endif

        </div>


        <h6 class="fw-bold text-truncate">

            {{ $book->judul_buku }}

        </h6>


        <p class="text-muted small">

            {{ $book->pengarang }}

        </p>

<a href="{{ route('books.show',$book->id_buku) }}"
    class="btn btn-light text-primary fw-semibold w-100 btn-sm">

    View Details

</a>

    </div>

</div>


@empty


<div class="col-12">

    <div class="text-center py-5">

        <i class="bi bi-search display-4"></i>

        <h5 class="mt-3">

            Buku tidak ditemukan

        </h5>

        <p class="text-muted">

            Coba gunakan kata kunci lain

        </p>

    </div>

</div>


@endforelse

</div>