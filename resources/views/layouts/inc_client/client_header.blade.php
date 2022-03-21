<header id="header" class="header header-style-1">
    <div class="container-fluid">
        <div class="row">
            <div class="topbar-menu-area">
                <div class="container">
                    <div class="topbar-menu left-menu">
                        <ul>
                            <li class="menu-item">
                                <a title="Hotline: (+123) 456 789" href="#"><span
                                        class="icon label-before fa fa-mobile"></span>Hotline: {{ getConfigValue('phone') }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="topbar-menu right-menu">
                        {{-- <ul>
                            <li class="menu-item" ><a title="Register or Login" href="login.html">Login</a></li>
                            <li class="menu-item" ><a title="Register or Login" href="register.html">Register</a></li> --}}
                            {{-- <li class="menu-item lang-menu menu-item-has-children parent">
                                <a title="English" href="#"><span class="img label-before"><img src="{{ asset('clients/assets/images/lang-en.png') }}" alt="lang-en"></span>English<i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                <ul class="submenu lang" >
                                    <li class="menu-item" ><a title="hungary" href="#"><span class="img label-before"><img src="{{ asset('clients/assets/images/lang-hun.png') }}" alt="lang-hun"></span>Hungary</a></li>
                                    <li class="menu-item" ><a title="german" href="#"><span class="img label-before"><img src="{{ asset('clients/assets/images/lang-ger.png') }}" alt="lang-ger" ></span>German</a></li>
                                    <li class="menu-item" ><a title="french" href="#"><span class="img label-before"><img src="{{ asset('clients/assets/images/lang-fra.png') }}" alt="lang-fre"></span>French</a></li>
                                    <li class="menu-item" ><a title="canada" href="#"><span class="img label-before"><img src="{{ asset('clients/assets/images/lang-can.png') }}" alt="lang-can"></span>Canada</a></li>
                                </ul>
                            </li> --}}
                            {{-- <li class="menu-item menu-item-has-children parent" >
                                <a title="Dollar (USD)" href="#">Dollar (USD)<i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                <ul class="submenu curency" >
                                    <li class="menu-item" >
                                        <a title="Pound (GBP)" href="#">Pound (GBP)</a>
                                    </li>
                                    <li class="menu-item" >
                                        <a title="Euro (EUR)" href="#">Euro (EUR)</a>
                                    </li>
                                    <li class="menu-item" >
                                        <a title="Dollar (USD)" href="#">Dollar (USD)</a>
                                    </li>
                                </ul>
                            </li> 
                        </ul> --}}
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="mid-section main-info-area">

                    <div class="wrap-logo-top left-section">
                        <a href="index.html" class="link-to-home"><img
                                src="{{ asset('clients/assets/images/logo-top-1.png') }}" alt="mercado"></a>
                    </div>

                    <div style="position: relative" class="wrap-search center-section">
                        <div class="wrap-search-form">
                            <form action="{{ route('search') }}" id="form-search-top" name="form-search-top">
                                @csrf
                                <input id="search_product" type="text" name="search" placeholder="Nhập tên sản phẩm...">
                                <button form="form-search-top" type="button"><i class="fa fa-search"
                                        aria-hidden="true"></i></button>
                            </form>
                        </div>
                        <div id="search_data" style="width: 75%; overflow: auto; max-height:37em; position: absolute; left: 50%;transform: translateX(-50%); z-index: 200; background-color: rgb(251, 251, 251)">
                        
                        </div>
                    </div>

                    <div class="wrap-icon right-section">
                        <div class="wrap-icon-section minicart">
                            <a href="{{ route('cart') }}" class="link-direction">
                                <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                                <div class="left-info">
                                    <span id="cartCount" class="index">{{ Cart::count() }} SP</span>
                                    <span class="title">Giỏ hàng</span>
                                </div>
                            </a>
                        </div>
                        <div class="wrap-icon-section show-up-after-1024">
                            <a href="#" class="mobile-navigation">
                                <span></span>
                                <span></span>
                                <span></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="nav-section header-sticky">
                <div class="primary-nav-section">
                    <div class="container">
                        <ul class="nav primary clone-main-menu" id="mercado_main" data-menuname="Main menu">
                            <li class="menu-item {{ session('module_active') == 'home' ? 'home-icon' : '' }}">
                                <a href="{{ route('home') }}" class="link-term mercado-item-title"><i
                                        style="font-size:1.2em" class="fa fa-home" aria-hidden="true"></i></a>
                            </li>
                            <li class="menu-item {{ session('module_active') == 'shop' ? 'home-icon' : '' }}">
                                <a href="{{ route('shop') }}" class="link-term mercado-item-title">Shop</a>
                            </li>
                            <li class="menu-item {{ session('module_active') == 'cart' ? 'home-icon' : '' }}">
                                <a href="{{ route('cart') }}" class="link-term mercado-item-title">Giỏ hàng</a>
                            </li>
                            <li class="menu-item {{ session('module_active') == 'checkout' ? 'home-icon' : '' }}">
                                <a href="{{ route('checkout') }}" class="link-term mercado-item-title">Đặt hàng</a>
                            </li>
                            <li class="menu-item {{ session('module_active') == 'contact' ? 'home-icon' : '' }}">
                                <a href="{{ route('contact') }}" class="link-term mercado-item-title">Liên hệ</a>
                            </li>
                            <li class="menu-item {{ session('module_active') == 'about' ? 'home-icon' : '' }}">
                                <a href="{{ route('about') }}" class="link-term mercado-item-title">Giới thiệu</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
