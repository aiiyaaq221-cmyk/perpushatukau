document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".form-delete").forEach(form => {
        form.addEventListener("submit", function(e){
            e.preventDefault();

            Swal.fire({
                title: "Hapus Data?",
                text: "Data pengunjung yang dihapus tidak dapat dikembalikan.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Ya, Hapus",
                cancelButtonText: "Batal"
            }).then((result)=>{

                if(result.isConfirmed){
                    form.submit();
                }
            });
        });
    });
});