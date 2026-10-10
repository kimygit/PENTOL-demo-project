
$(document).ready(function() {
    // Cek dulu apakah DataTable sudah ada supaya gak error saat include
    if ( ! $.fn.DataTable.isDataTable( '#tabelPengguna' ) ) {
        $('#tabelPengguna').DataTable({
            "responsive": true,
            "language": {
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ pengguna"
            }
        });
    }
});
