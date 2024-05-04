<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Page</title>
    <style>
    body.dark-bg,
    .nk-sidebar.dark-bg {
        background-color: #1F2937 !important;
    }
</style>
</head>

<body class="dark-bg">
    <div class="nk-sidebar nk-sidebar-fixed is-theme dark-bg" id="sidebar">
        <div class="nk-sidebar-element nk-sidebar-head">
            <div class="nk-sidebar-brand">
                <a href="{{ route('dashboard') }}" class="logo-link">
                    <div class="logo-wrap" style="display: flex; justify-content: center; align-items: center;">
                        <img class="logo-svg" src="{{ asset('assets/images/favicon.png') }}" alt="" width="100" height="200">
                    </div>
                </a>
            </a>

        </div>
    </div>
    <div class="nk-sidebar-element nk-sidebar-body">
        <div class="nk-sidebar-content">
            <div class="nk-sidebar-menu" data-simplebar>
                <ul class="nk-menu">
                    <li class="{{ request()->is('/') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}" class="nk-menu-link">
                            <span class="nk-menu-icon">
                                <em class="icon ni ni-home"></em>
                            </span>
                            <span class="nk-menu-text">Trang chủ</span>
                        </a>
                    </li>
                    @auth
                        <li class="{{ request()->is('hang-hoa*') ? 'active' : '' }}">
                            <a href="{{ route('hang-hoa.index') }}" class="nk-menu-link">
                                <span class="nk-menu-icon">
                                    <em class="icon ni ni-package"></em>
                                </span><span class="nk-menu-text">Quản lý hàng hóa</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('loai-hang*') ? 'active' : '' }}">
                            <a href="{{ route('loai-hang.index') }}" class="nk-menu-link">
                                <span class="nk-menu-icon">
                                    <em class="icon ni ni-layers"></em>
                                </span>
                                <span class="nk-menu-text">Quản lý loại hàng hóa</span>
                            </a>
                        </li>
                        <li class="{{ request()->is('nha-cung-cap*') ? 'active' : '' }}">
                            <a href="{{ route('nha-cung-cap.index') }}" class="nk-menu-link">
                                <span class="nk-menu-icon">
                                    <em class="icon ni ni-building"></em>
                                </span>
                                <span class="nk-menu-text">Quản lý nhà cung cấp</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('nhap-kho*') ? 'active' : '' }}">
                            <a href="{{ route('nhap-kho.index') }}" class="nk-menu-link">
                                <span class="nk-menu-icon">
                                    <em class="icon ni ni-archive"></em>
                                </span>
                                <span class="nk-menu-text">Quản lý nhập kho</span>
                            </a>
                        </li>

                        <li class="{{ request()->is('xuat-kho*') ? 'active' : '' }}">
                            <a href="{{ route('xuat-kho.index') }}" class="nk-menu-link">
                                <span class="nk-menu-icon">
                                    <em class="icon ni ni-unarchive"></em>
                                </span>
                                <span class="nk-menu-text">Quản lý xuất kho</span>
                            </a>
                        </li>



                        <li class="{{ request()->is('thong-ke*') ? 'active' : '' }}">
                            <a href="{{ route('thong-ke.index') }}" class="nk-menu-link">
                                <span class="nk-menu-icon">
                                    <em class="icon ni ni-todo"></em>
                                </span>
                                <span class="nk-menu-text">Thống kê</span>
                            </a>

                        </li>
                        @can('user')
                            <li class="{{ request()->is('tai-khoan*') ? 'active' : '' }}">
                                <a href="{{ route('tai-khoan.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon">
                                        <em class="icon ni ni-users"></em>
                                    </span>
                                    <span class="nk-menu-text">Quản lý tài khoản</span>
                                </a>
                            </li>
                        @endcan
                        @can('user')
                        <li class="{{ request()->is('tai-khoan*') ? 'active' : '' }}">
                            <a href="{{ route('user.show') }}" class="nk-menu-link">
                                <span class="nk-menu-icon">
                                    <em class="icon ni ni-users"></em>
                                </span>
                                <span class="nk-menu-text">Thông tin cá nhân</span>
                            </a>
                        </li>
                    @endcan
                        
                        <li class="{{ request()->is('thông tin cá nhân*') ? 'active' : '' }}">
                            <a href="{{ route('logout') }}" class="nk-menu-link">
                                <span class="nk-menu-icon">
                                    <em class="icon ni ni-signout"></em>
                                </span>
                                <span class="nk-menu-text">Đăng xuất:</span>
                            </a>
                        </li>




                    @endauth
                </ul>
            </div>
        </div>
    </div>
</div>
</body>
