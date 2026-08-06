<!-- FEATURED BOOKS SECTION -->
<section class="{{ request()->filled('search') ? 'mt-3 mb-5' : 'my-5' }}" id="books">
    
    @if(!request()->filled('search'))
        <div class="position-relative text-center mb-4">
            <h4 class="fw-bold mb-2"> Featured Books </h4>
            <p class="text-muted small mb-0"> Rekomendasi buku populer minggu ini </p>
            <a href="{{ route('books.index') }}"  class="btn btn-sm btn-outline-primary rounded-pill px-3 position-absolute top-50 end-0 translate-middle-y"> View All </a>
        </div>
    @endif

    <div id="book-list">
        @include('partials.book-list')
    </div>


</section>