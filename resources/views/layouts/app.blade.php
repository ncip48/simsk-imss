<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - IMSS</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Themestyle -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@5/dark.css" />

    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
        rel="stylesheet">

    @stack('styles')

    @livewireStyles
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="https://imsservice.co.id/assets/inka-border.png" alt="AdminLTELogo"
                height="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>

            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('dashboard') }}" class="brand-link d-flex">
                <img src="https://imsservice.co.id/assets/inka-border.png" alt="AdminLTE Logo"
                    class="brand-image mx-auto d-block" style="opacity: .8">
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
                    <div class="image">
                        <img src="dist/img/user.png" class="img-circle" alt="User Image">
                    </div>
                    <div class="info" style="text-wrap:wrap">
                        @php
                            $divisi = \App\Models\Divisi::where('id_divisi', Auth::user()->id_divisi)->first();
                        @endphp
                        <a class="d-block">{{ Auth::user()->name }} - {{ $divisi->nama }}</a>
                    </div>
                </div>

                {{-- <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div> --}}

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}"
                                class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('surat-keluar') }}"
                                class="nav-link {{ request()->is('surat-keluar') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-envelope"></i>
                                <p>
                                    Surat Keluar
                                </p>
                            </a>
                        </li>

                        {{-- Aset Inventaris --}}

                        @if (Auth::user()->id_divisi === 5)
                            
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-archive"></i>
                                <p>
                                    Aset Inventaris
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('kode-aset') }}"
                                        class="nav-link {{ request()->is('kode-aset') ? 'active' : '' }}">
                                        {{-- <i class="nav-icon fas fa-qrcode"></i> --}}
                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                        <p>
                                            Kode Asset SDM
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('asset') }}"
                                        class="nav-link {{ request()->is('asset') ? 'active' : '' }}">
                                        {{-- <i class="nav-icon fas fa-archive"></i> --}}
                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                        <p>
                                            Aset SDM
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('inventaris') }}"
                                        class="nav-link {{ request()->is('inventaris') ? 'active' : '' }}">
                                        {{-- <i class="nav-icon fas fa-money-check-alt"></i> --}}
                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                        <p>
                                            Inventaris SDM
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('penghapusan-aset')}}"
                                        class="nav-link {{ request()->is('penghapusan-aset') ? 'active' : '' }}">
                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                        <p>
                                           Penghapusan Aset
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('pengaduan') }}"
                                        class="nav-link {{ request()->is('pengaduan') ? 'active' : '' }}">
                                        {{-- <i class="nav-icon fas fa-exclamation"></i> --}}
                                        <i class="nav-icon far fa-circle nav-icon"></i>
                                        <p>
                                            Pengaduan Aset
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif

                        {{-- TTD Surat --}}
                        <li class="nav-item {{ request()->is('tanda-tangan') || request()->is('dokumen') ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ request()->is('tanda-tangan') || request()->is('dokumen') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-signature"></i>
                                <p>
                                    TTD Digital [Beta]
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('tanda-tangan') }}"
                                        class="nav-link {{ request()->is('tanda-tangan') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Manage Tanda Tangan</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('dokumen') }}"
                                        class="nav-link {{ request()->is('dokumen') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Dokumen</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        
                        {{-- <li class="nav-item">
                            <a href="{{ route('generate-surat') }}"
                                class="nav-link {{ request()->is('generate-surat') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-envelope-open-text"></i>
                                <p>
                                    Generate Surat
                                </p>
                            </a>
                        </li> --}}

                        @if (Auth::user()->role === 1)
                            <li class="nav-item">
                                <a href="{{ route('divisi') }}"
                                    class="nav-link {{ request()->is('divisi') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-building"></i>
                                    <p>
                                        Divisi
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user') }}"
                                    class="nav-link {{ request()->is('user') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>
                                        User
                                    </p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('edit-profile') }}"
                                class="nav-link {{ request()->is('edit-profile') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-cog"></i>
                                <p>
                                    Edit Profile
                                </p>
                            </a>
                        </li>
                        <form action="{{ route('logout') }}" id="logout" method="POST">
                            @csrf
                        </form>
                        <li class="nav-item">
                            <a onclick="document.getElementById('logout').submit();" class="nav-link"
                                style="cursor: pointer">
                                <i class="nav-icon fa fa-sign-out-alt"></i>
                                <p>Logout</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        @yield('content')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; {{ now()->year }} <a href="https://imsservice.co.id/">PT. IMSS</a></strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                Template by AdminLTE <b>Version</b> 3.2.0
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>

    <!-- PAGE PLUGINS -->
    <!-- jQuery Mapael -->
    <script src="{{ asset('plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
    <script src="{{ asset('plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>

    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('dist/js/pages/dashboard2.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>


    @stack('scripts')

    <script>
        $(function() {
            $("#example1").DataTable({
                "lengthChange": false,
                "autoWidth": true,
            })
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
            });
        });
    </script>

    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            showCloseButton: true,
            timer: 4000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        window.addEventListener('alert', event => {
            const {
                type,
                message
            } = event.detail[0]
            Toast.fire({
                icon: type,
                title: message
            })
        })
    </script>

    <script>
        document.addEventListener('livewire:available', function() {
            window.livewire.on('fileChoosen', () => {
                let inputField = document.getElementById('file')
                let file = inputField.files[0]
                let reader = new FileReader();
                reader.onloadend = () => {
                    Livewire.emit('fileUpload', reader.result)
                    console.log(reader.result)
                }
                reader.readAsDataURL(file);
            })
        });
    </script>

    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script>
        FilePond.registerPlugin(FilePondPluginFileValidateType);
        FilePond.registerPlugin(FilePondPluginFileValidateSize);
        FilePond.registerPlugin(FilePondPluginImagePreview);
    </script>
    <script>
        this.addEventListener('pondReset', e => {
            // console.log(FilePond.destroy(document.querySelector('input[name="filepond"]')))
            FilePond.destroy(document.querySelector('input[name="filepond"]'))
        });
    </script>


    @livewireScripts

</body>

</html>
