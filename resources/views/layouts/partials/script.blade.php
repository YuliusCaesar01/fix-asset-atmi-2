<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('vendor/js/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('vendor/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('vendor/js/Chart.min.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('vendor/js/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('vendor/js/moment.min.js') }}"></script>
<script src="{{ asset('vendor/js/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('vendor/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('vendor/js/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('vendor/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('vendor/js/adminlte.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('vendor/js/dashboard.js') }}"></script>



<!-- DataTables  & Plugins -->
<script src="{{ asset('vendor/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendor/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('vendor/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('vendor/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/js/jszip.min.js') }}"></script>
<script src="{{ asset('vendor/js/pdfmake.min.js') }}"></script>
<script src="{{ asset('vendor/js/vfs_fonts.js') }}"></script>
<script src="{{ asset('vendor/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('vendor/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('vendor/js/buttons.colVis.min.js') }}"></script>
@yield('scripttambahan')
<!-- Page specific script -->
<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
