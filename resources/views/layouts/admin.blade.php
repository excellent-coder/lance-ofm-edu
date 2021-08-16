<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | Dashboard </title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="/vendor/fontawesome/all.min.css">
    <link rel="stylesheet" href="/vendor/overlayScrollbars/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="/vendor/select2/select2.min.css">
    <link rel="stylesheet" href="/css/admin/adminlte.min.css">
    <link rel="stylesheet" href="/css/admin/app.css">
    @yield('css')
</head>

<body class="hold-transition {{$admin_theme}} sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper" id="adminApp">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="/storage/{{web_setting('general', 'logo')}}" alt="web Logo" height="60" width="60">
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
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="/vendor/overlayScrollbars/jquery.overlayScrollbars.min.js"></script>
    <script src="/js/admin/adminlte.min.js"></script>
    <script src="/vendor/select2/select2.min.js"></script>
    {{-- add vue files --}}

    <script src="/js/admin/manifest.js"></script>
    <script src="/js/admin/vendor.js"></script>
    <script src="/js/admin/app.js"></script>
    @yield('js')

    <script>
        let toolbar= `undo redo | bold italic underline strikethrough
        | fontselect fontsizeselect formatselect
        | alignleft aligncenter alignright alignjustify
        | outdent indent |  numlist bullist
        | forecolor backcolor removeformat
        | pagebreak | charmap emoticons
        | fullscreen  preview save print
        | insertfile image media template link anchor codesample | ltr rtl | code`;

        let plugins = `print
        preview paste importcss searchreplace autolink autosave save directionality code
        visualblocks visualchars fullscreen image link media template codesample table
        charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists
        wordcount imagetools textpattern noneditable help charmap quickbars emoticons code`;


    let formats= {
    borderstyle: { selector: 'td,th', styles: { borderTopStyle: 'solid', borderRightStyle: 'solid', borderBottomStyle: 'solid', borderLeftStyle: 'solid', }, remove_similar: true },
    bordercolor: { selector: 'td,th', styles: { borderTopColor: '#32CD32', borderRightColor: '#32CD32', borderBottomColor: '#32CD32', borderLeftColor: '#32CD32' }, remove_similar: true },
    backgroundcolor: { selector: 'td,th', styles: { backgroundColor: '#006400' }, remove_similar: true },
  };

        $(document).ready(function () {
            if (window.tinymce) {
                tinymce.init({
                    selector:'.tinymce',
                    plugins,
                    toolbar,
                    menubar: 'file edit view insert format tools table help',
                    imagetools_cors_hosts: ['picsum.photos'],
                    branding: false,
                    images_upload_url: "{{route('admin.tinymce')}}",
                    automatic_uploads: true,
                    images_upload_base_path: '/storage',
                    toolbar_sticky: true,
                    autosave_ask_before_unload: true,


                    image_advtab: true,
                    convert_urls: false,
                    relative_url: false,
                    // link
                    default_link_target: '_blank',
                    link_context_toolbar: true,
                    link_default_protocol: 'https',
                    rel_list: [
                        {title: 'No Referrer', value: 'noreferrer'},
                        {title: 'External Link', value: 'external'}
                    ],

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
