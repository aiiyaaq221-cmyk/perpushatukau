<!DOCTYPE html>
<html>
<head>
    <title>Perpustakaan Hatukau</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    @yield('styles')
</head>

<body>

<div class="wrapper">

    @include('layouts.sidebar')

    <main class="content">
        @yield('content')
    </main>

</div>

<!-- SIDEBAR TOGGLE -->
<script>
document.querySelectorAll('.has-submenu > a').forEach(item => {
    item.addEventListener('click', function (e) {
        e.preventDefault();
        this.parentElement.classList.toggle('open');
    });
});
</script>

<!-- =========================
     SAFE SCRIPTS (FIX ERROR)
========================= -->

<script>
let timer;

/* =========================
   SEARCH INPUT (BUKU)
========================= */
const searchInput = document.getElementById('searchInput');

if (searchInput) {
    searchInput.addEventListener('keyup', function () {
        clearTimeout(timer);

        timer = setTimeout(() => {
            this.form.submit();
        }, 500);
    });
}

/* =========================
   NAMA INPUT (LAPORAN)
========================= */
const namaInput = document.getElementById('namaInput');

if (namaInput) {
    namaInput.addEventListener('keyup', function () {
        clearTimeout(timer);

        timer = setTimeout(() => {
            const form = document.getElementById('filterForm');
            if (form) form.submit();
        }, 500);
    });
}

/* =========================
   AUTO SUBMIT SELECT
========================= */
document.querySelectorAll('.auto-submit').forEach(function (element) {
    element.addEventListener('change', function () {
        const form = document.getElementById('filterForm');
        if (form) form.submit();
    });
});
</script>

<!-- SIDEBAR -->
<script>

const sidebar = document.querySelector('.sidebar');
const content = document.querySelector('.content');
const resizer = document.getElementById('sidebarResizer');

let isResizing = false;

const savedWidth = localStorage.getItem('sidebarWidth');

if(savedWidth){

    sidebar.style.width = savedWidth + 'px';
    content.style.marginLeft = savedWidth + 'px';
    resizer.style.left = savedWidth + 'px';
}

resizer.addEventListener('mousedown', () => {

    isResizing = true;

});

document.addEventListener('mousemove', (e) => {

    if(!isResizing) return;

    let width = e.clientX;

    if(width < 220) width = 220;
    if(width > 450) width = 450;

    sidebar.style.width = width + 'px';
    content.style.marginLeft = width + 'px';
    resizer.style.left = width + 'px';

    localStorage.setItem(
        'sidebarWidth',
        width
    );

});

document.addEventListener('mouseup', () => {

    isResizing = false;

});

</script>

<!-- =========================
     LIBRARY
========================= -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@stack('scripts')

</body>
</html>