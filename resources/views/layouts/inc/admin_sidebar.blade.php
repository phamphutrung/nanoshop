<aside class="main-sidebar sidebar-dark-primary elevation-4" style="position: fixed;">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Nano Shop</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex text-white">
      <div class="image mt-1">
         {{-- <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">  --}}
        <i class="fa-solid fa-user "></i>
      </div>
      <div class="info">
        <strong href="#" class="d-block">{{ Auth::user()->name }}</strong>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="{{ route('dashboard') }}" class="nav-link {{ session('module_active')=='dashboard'?'active':'' }}">
            <i class="nav-icon fas fa-chart-line"></i>
            <p>
                Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin-category') }}" class="nav-link {{ session('module_active')=='category'?'active':'' }}" >
            <i class="nav-icon fas  fa-list-alt"></i>
            <p>
                Danh Mục
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin-product') }}" class="nav-link {{ session('module_active')=='product'?'active':'' }}">
            <i class="nav-icon fas fa-solid fa-align-center"></i>
            <p>
                Sản Phẩm
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin-user') }}" class="nav-link {{ session('module_active')=='user'?'active':'' }}">
            <i class="nav-icon fas fa-users"></i>
            <p>
                 Thành viên
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin-role') }}" class="nav-link {{ session('module_active')=='role'?'active':'' }}">
            <i class="nav-icon fa-solid fa-hand-back-fist"></i>
            <p>
                 Vai trò thanh viên
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin-slider') }}" class="nav-link {{ session('module_active')=='slider'?'active':'' }}">
            <i class="nav-icon fa-solid fa-sliders"></i>
            <p>
                 Slider
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin-setting') }}" class="nav-link {{ session('module_active')=='setting'?'active':'' }}">
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