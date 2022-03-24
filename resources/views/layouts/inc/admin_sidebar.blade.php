<aside class="main-sidebar sidebar-dark-primary elevation-4" style="position: fixed;">
    <!-- Brand Logo -->

    <div class="text-center border-bottom border-secondary mt-3 pb-2">
        <img width="150px" src="{{ asset('admins/image/Daco_2768952.png') }}" alt="Logo" class="">
    </div>


    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex text-white align-item-center">
            <div class="image">
                @if (Auth::user()->avt == null)
                    <img src="https://toigingiuvedep.vn/wp-content/uploads/2021/01/hinh-anh-cute-de-thuong-600x600.jpg"
                        style="border-radius: 50%; width: 35px; height: 35px" alt="User Image">
                @else
                    <img src="{{ asset('storage/' . Auth::user()->avt) }}"
                        style="border-radius: 50%; width: 35px; height: 35px" alt="User Image">
                @endif
            </div>
            <div class="info" style="width: 100%">
                <strong href="#" class="d-block">{{ Auth::user()->name }}</strong>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('account') }}"
                        class="nav-link {{ session('module_active') == 'account' ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-user "></i>
                        <p>
                            Tài khoản
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin-order') }}"
                        class="nav-link {{ session('module_active') == 'order' ? 'active' : '' }}">
                        <i class="nav-icon fa-regular fa-hard-drive"></i>
                        <p>
                            Đơn Hàng
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin-category') }}"
                        class="nav-link {{ session('module_active') == 'category' ? 'active' : '' }}">
                        <i class="nav-icon fas  fa-list-alt"></i>
                        <p>
                            Danh Mục
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin-product') }}"
                        class="nav-link {{ session('module_active') == 'product' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-solid fa-align-center"></i>
                        <p>
                            Sản Phẩm
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin-user') }}"
                        class="nav-link {{ session('module_active') == 'user' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Thành viên
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin-role') }}"
                        class="nav-link {{ session('module_active') == 'role' ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-hand-back-fist"></i>
                        <p>
                            Vai trò thanh viên
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin-slider') }}"
                        class="nav-link {{ session('module_active') == 'slider' ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-sliders"></i>
                        <p>
                            Slider
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin-setting') }}"
                        class="nav-link {{ session('module_active') == 'setting' ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-gear"></i>
                        <p>
                            Cài Đặt
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin-category') }}" class="nav-link ">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
                            Log Out
                        </p>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
