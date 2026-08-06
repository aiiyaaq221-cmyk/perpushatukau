@extends('layouts.welcome')

@section('title', 'Semua Buku')

@section('content')

<div class="container py-5">

    <div class="text-center mb-5">

    <h2 class="fw-bold">

        Semua Buku

    </h2>

    <p class="text-muted">

        Tingkatkan literasi membacamu hari ini!

    </p>

</div>


    {{-- Form Search --}}
    <form action="{{ route('books.index') }}" method="GET" class="mb-4">

        <div class="search-container shadow-sm rounded-pill p-2">

            <div class="input-group">

                <span class="input-group-text bg-white border-0">

                    <i class="bi bi-search"></i>

                </span>

                <input type="text" id="searchBook"
                    name="search" class="form-control border-0 shadow-none"
                    placeholder="Cari judul buku atau nama pengarang..."
                    value="{{ request('search') }}" autocomplete="off">

                <button class="btn btn-primary rounded-pill px-4"> Cari </button>
            </div>
        </div>
    </form>


    {{-- Kategori --}}
    <!-- <div class="mb-5 d-flex flex-wrap gap-2">

        <a href="{{ route('books.index') }}"
           class="btn {{ request()->filled('kategori') ? 'btn-outline-secondary' : 'btn-primary' }} rounded-pill">
            Semua
        </a>

        @foreach($kategoris as $kategori)

            <a href="{{ route('books.index', ['kategori' => $kategori->id]) }}"
               class="btn {{ request('kategori') == $kategori->id ? 'btn-primary' : 'btn-outline-secondary' }} rounded-pill">
                {{ $kategori->nama_kategori }}
            </a>

        @endforeach

    </div> -->

<div class="d-flex flex-wrap gap-2 mb-5">

    <a href="{{ route('books.index') }}"
        class="btn btn-primary rounded-pill">

        Semua

    </a>

    @foreach($kategoris as $kategori)

        <a href="{{ route('books.index',[
            'kategori'=>$kategori->id
        ]) }}"
        class="btn btn-outline-primary rounded-pill">

            {{ $kategori->nama_kategori }}

        </a>

    @endforeach

</div>

    {{-- Buku --}}
    @include('partials.book-list', [
        'books' => $books
    ])


    <div class="mt-5 ">

        {{ $books->links() }}

    </div>

</div>

@endsection