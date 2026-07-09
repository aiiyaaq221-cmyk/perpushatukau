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
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    @yield('styles')
</head>

<body>
<div class="wrapper" id="wrapper">
    @include('layouts.sidebar')
    <main class="content" id="content">
        @yield('content')
    </main>
</div>

@if(session('login_success'))
<div id="login-success"
     class="position-fixed bottom-0 start-50 translate-middle-x mb-4
            bg-success text-white px-4 py-2 rounded shadow"
     style="z-index:9999; font-size:14px;">
    {{ session('login_success') }}
</div>

<script>
setTimeout(function() {
    const notif = document.getElementById('login-success');
    if(notif){
        notif.remove();
    }
}, 3000);
</script>
@endif

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
     AUTO SEARCH
=========================================== -->

<script>
let timer;
    const searchInput = document.getElementById('searchInput');
    if(searchInput){
        searchInput.addEventListener('keyup',function(){
            clearTimeout(timer);
            timer=setTimeout(()=>{
                this.form.submit();
            },500);
        });
    }

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

@yield('scripts')

@stack('scripts')


<!-- ===========================================
     TOGGLE DAFTAR BUKU
=========================================== -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggle-books').forEach(function(btn){
        btn.addEventListener('click', function(){
            const target = document.getElementById(this.dataset.target);
            if(!target) return;
            if(target.style.display === 'none' || target.style.display === ''){
                target.style.display = 'block';
                this.innerHTML = '<i class="fas fa-chevron-up me-1"></i> Lebih sedikit';

            }else{
                target.style.display = 'none';
                this.innerHTML = '+' + this.dataset.count + ' lainnya';
            }
        });
    });
});
</script>



</body>
</html>