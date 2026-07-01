<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Hatukau</title>
    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <!-- CSS -->
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


<!-- ===========================================
     LIBRARY
=========================================== -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/sidebar.js') }}"></script>


<!-- ===========================================
     GLOBAL SWEET ALERT CONFIG
=========================================== -->
<script>
const swalConfig = {
    customClass:{
        popup:'swal-modern'
    },
    buttonsStyling:false,
    reverseButtons:true,
    confirmButtonColor:'#2563eb',
    cancelButtonColor:'#6b7280'
};
</script>


<!-- ===========================================
     SIDEBAR MENU
=========================================== -->

<script>
document.querySelectorAll('.has-submenu > a').forEach(item=>{
    item.addEventListener('click',function(e){
        e.preventDefault();
        this.parentElement.classList.toggle('open');
    });
});
</script>


<!-- ===========================================
     AUTO SEARCH
=========================================== -->

<script>
let timer;
/* SEARCH */
const searchInput = document.getElementById('searchInput');
if(searchInput){
    searchInput.addEventListener('keyup',function(){
        clearTimeout(timer);
        timer=setTimeout(()=>{
            this.form.submit();
        },500);
    });
}


/* FILTER */

const namaInput=document.getElementById('namaInput');
if(namaInput){
    namaInput.addEventListener('keyup',function(){
        clearTimeout(timer);
        timer=setTimeout(()=>{
            const form=document.getElementById('filterForm');
            if(form){
                form.submit();
            }
        },500);
    });
}


document.querySelectorAll('.auto-submit').forEach(function(item){
    item.addEventListener('change',function(){
        const form=document.getElementById('filterForm');
        if(form){
            form.submit();
        }
    });
});
</script>



<!-- ===========================================
     SIDEBAR RESIZER
=========================================== -->
<script>
const sidebar=document.querySelector('.sidebar');
const content=document.querySelector('.content');
const resizer=document.getElementById('sidebarResizer');
let isResizing=false;
const savedWidth=localStorage.getItem('sidebarWidth');

    if(savedWidth){
        sidebar.style.width=savedWidth+'px';
        content.style.marginLeft=savedWidth+'px';
        resizer.style.left=savedWidth+'px';
    }

    resizer.addEventListener('mousedown',()=>{
        isResizing=true;
    });

    document.addEventListener('mousemove',(e)=>{
        if(!isResizing) return;
        let width=e.clientX;
        if(width<220) width=220;
        if(width>450) width=450;
        sidebar.style.width=width+'px';
        content.style.marginLeft=width+'px';
        resizer.style.left=width+'px';
        localStorage.setItem(
            'sidebarWidth',
            width
        );
    });

    document.addEventListener('mouseup',()=>{
        isResizing=false;
    });
</script>




<!-- ===========================================
     SUCCESS
=========================================== -->
@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text:'{{ session("success") }}',
        showConfirmButton:false,
        timer:2200,
        timerProgressBar:false,
        allowOutsideClick:false,
        backdrop:'rgba(0,0,0,.45)',
        customClass:{
            popup:'popup-success'
        }
    });
});
</script>
@endif



<!-- ===========================================
     ERROR
=========================================== -->
@if(session('error'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon:'error',
        title: 'Error',
        text:'{{ session("error") }}',
        showConfirmButton:false,
        timer:2500,
        backdrop:'rgba(0,0,0,.45)',
        customClass:{
            popup:'popup-success'
        }
    });
});
</script>
@endif


<!-- ===========================================
     VALIDATION
=========================================== -->
@if($errors->any())
<script>
document.addEventListener('DOMContentLoaded', function () {

    Swal.fire({
        toast:true,
        position:'center',
        icon:'error',
        title:'{{ $errors->first() }}',
        showConfirmButton:false,
        timer:3000,
        timerProgressBar:true,
        customClass:{
            popup:'swal-toast'
        }
    });
});
</script>
@endif


@stack('scripts')

</body>
</html>