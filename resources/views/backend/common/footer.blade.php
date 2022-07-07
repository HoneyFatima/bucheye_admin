@section('footer')
    <!-- jQuery -->
    <script src="{{ url('backend/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ url('backend/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ url('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ url('backend/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="{{ url('backend/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ url('backend/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ url('backend/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ url('backend/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ url('backend/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ url('backend/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ url('backend/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ url('backend/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ url('backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ url('backend/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ url('backend/plugins/toastr/toastr.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ url('backend/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ url('backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ url('backend/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('backend/dist/js/adminlte.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ url('backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ url('backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ url('backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ url('backend/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ url('backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ url('backend/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ url('backend/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ url('backend/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ url('backend/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ url('backend/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ url('backend/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>

    {{-- <!-- AdminLTE for demo purposes -->
<script src="{{url('backend/dist/js/demo.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{url('backend/dist/js/pages/dashboard.js')}}"></script> --}}
    <script>
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        $('table').DataTable({
            "dom": 'lrftip',
            "paging": false,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        });
        const AmagiLoader = {
            __loader: null,
            show: function() {

                if (this.__loader == null) {
                    var divContainer = document.createElement('div');
                    divContainer.style.position = 'fixed';
                    divContainer.style.left = '0';
                    divContainer.style.top = '0';
                    divContainer.style.width = '100%';
                    divContainer.style.height = '100%';
                    divContainer.style.backgroundColor = 'rgba(250, 250, 250, 0.80)';

                    var div = document.createElement('div');
                    div.style.position = 'absolute';
                    div.style.left = '50%';
                    div.style.top = '50%';
                    div.style.zIndex = '9999';
                    div.style.height = '64px';
                    div.style.width = '64px';
                    div.style.margin = '-76px 0 0 -76px';
                    div.style.border = '8px solid #e1e1e1';
                    div.style.borderRadius = '50%';
                    div.style.borderTop = '8px solid #F36E21';
                    div.animate([{
                            transform: 'rotate(0deg)'
                        },
                        {
                            transform: 'rotate(360deg)'
                        }
                    ], {
                        duration: 2000,
                        iterations: Infinity
                    });
                    divContainer.appendChild(div);
                    this.__loader = divContainer
                    document.body.appendChild(this.__loader);
                }
                this.__loader.style.display = "";
            },
            hide: function() {
                if (this.__loader != null) {
                    this.__loader.style.display = "none";
                }
            }
        }
    </script>
    @stack('scripts')
@endsection
