<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | Dashboard </title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="/vendor/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/vendor/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="/vendor/select2/css/select2.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/css/adminlte.min.css">
    <link rel="stylesheet" href="/css/admin/app.css">
    @yield('css')
</head>

<body class="hold-transition {{$admin_theme}} sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper" id="adminApp">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="/storage/web/logo.png" alt="web Logo" height="60" width="60">
        </div>
        <div id="preloader" style="display: block;">
            <div class="bars"></div>
        </div>
        {{-- Navbar --}}
        @include('admin.includes.navbar')
        {{-- /.navbar --}}

        <!-- Main Sidebar Container -->
        @include('admin.includes.sidebar')
        <!-- / .Sidebar Container -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <x-admin-breadcrumb></x-admin-breadcrumb>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <x-admin-aside title="changing is contant"></x-admin-aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; {{date('Y')}} <a href="/">Auction</a></strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="/vendor/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="/vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/js/adminlte.min.js"></script>

    <!-- PAGE /vendor -->
    <!-- jQuery Mapael -->
    <script src="/vendor/jquery-mousewheel/jquery.mousewheel.js"></script>
    <script src="/vendor/raphael/raphael.min.js"></script>
    <script src="/vendor/jquery-mapael/jquery.mapael.min.js"></script>
    <script src="/vendor/jquery-mapael/maps/usa_states.min.js"></script>
    <!-- ChartJS -->
    <script src="/vendor/chart.js/Chart.min.js"></script>
    {{-- select2 --}}
    <script src="/vendor/select2/js/select2.min.js"></script>

    {{-- add vue files --}}

    <script src="/js/admin/manifest.js"></script>
    <script src="/js/admin/vendor.js"></script>
    <script src="/js/admin/app.js"></script>
    @yield('js')

    <script>
        $(document).ready(function () {
            if (window.tinymce) {
                tinymce.init({
                    selector:'.tinymce',
                    plugins: 'wordcount, code, emoticons, image, autolink, colorpicker',
                    branding: false,
                    images_upload_url: "{{route('admin.tinymce')}}",
                    automatic_uploads: true,
                    images_upload_base_path: '/storage',

                    image_advtab: true,
                    convert_urls: false,
                    relative_url: false,

                    setup: (editor) => {
                        editor.on('change', () => {
                            editor.save()
                        });
                    }
                });
            }
            $('.select2').select2();
            $('#checkbox').on('click', function () {
                if (this.checked) {
                    $('.checking').each(function () {
                        this.checked = true;
                    });
                } else {
                    $('.checking').each(function () {
                        this.checked = false;
                    });
                }
                totalSelected();
            });


            $(document).on('click', function (e) {
                if (e.target.closest('#dataTable')) {

                    $('#dataTable').find('.action-btn').off('click');
                    $('#dataTable').find('.modal-edit-btn').off('click');
                    $('#dataTable').find('.activate-btn').off('click');
                    $('#dataTable').find('.checking').off('click');

                    $('#dataTable').find('.checking').on('click', function (e) {
                        return totalSelected();
                    })

                    $('#dataTable').find('.action-btn').on('click', function (e) {
                        e.preventDefault();
                        return Vm.methods.destroy(this);
                    })

                    $('#dataTable').find('.modal-edit-btn').on('click', function (e) {
                        e.preventDefault();
                        return Vm.methods.modalEdit(this);
                    })

                    $('#dataTable').find('.activate-btn').on('click', function (e) {
                        e.preventDefault();
                        return Vm.methods.activate(this);
                    })
                }
            })

            $('form').find('.required')
                .closest('div')
                .find('label')
                .append('<span class="text-danger">*</span>');
        });

    </script>
</body>

</html>
