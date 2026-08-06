@extends('layouts.welcome')

@section('title', 'Beranda')

@section('content')

<div class="container py-4">

    @include('partials.hero')
    @include('partials.about')
    @include('partials.why-choose')
    @include('partials.atmosphere')
    {{-- Panduan Meminjam Buku --}}
    @include('partials.guide')

    @include('partials.contact')

</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {

    const searchInput = document.getElementById("searchBook");

    if(searchInput){
        searchInput.addEventListener("input", function () {

            if (this.value.trim() === "") {
                window.location.href = "{{ route('welcome') }}";
            }

        });
    }

});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    @if(request()->filled('search'))

    const section = document.getElementById("books");

    if(section){
        section.scrollIntoView({
            behavior: "smooth",
            block: "start"
        });
    }

    @endif

});
</script>

<script>
function closeSearchAlert() {

    const alert = document.getElementById("searchAlert");

    if(alert){

        alert.style.transition = "opacity .3s ease";
        alert.style.opacity = "0";

        setTimeout(() => {
            alert.remove();
        }, 300);

    }

}
</script>
@endpush

@endsection
