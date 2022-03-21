@extends('layouts.client')

@section('content')
    <main id="main" class="main-site left-sidebar">
        <div class="container">
            <div class="wrap-breadcrumb">
                <ul>
                    <li class="item-link"><span>Đăng nhập</span></li>
                </ul>
            </div>
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 col-md-offset-3">
                    <div class=" main-content-area">
                        <div class="wrap-login-item ">
                            <div class="login-form form-item form-stl">
                                <form name="frm-login" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <fieldset class="wrap-title">
                                        <h3 class="form-title">Đăng nhập vào tài khoản của bạn</h3>
                                    </fieldset>
                                    <fieldset class="wrap-input">
                                        <label for="frm-login-uname">Email:</label>
                                        <input type="email" id="frm-login-uname" name="email" placeholder="Nhập email"
                                            value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </fieldset>
                                    <fieldset class="wrap-input">
                                        <label for="frm-login-pass">Mật khẩu:</label>
                                        <input type="password" id="frm-login-pass" placeholder="Nhập mật khẩu"
                                            name="password" required autocomplete="current-password">
                                        @error('pass')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </fieldset>

                                    <fieldset class="wrap-input">
                                        <label class="remember-field">
                                            <input class="frm-input " id="rememberme" type="checkbox" name="remember"
                                                {{ old('remember') ? 'checked' : '' }}><span>Ghi nhớ đăng nhập</span>
                                        </label>
                                    </fieldset>
                                    <input type="submit" class="btn btn-submit" value="Đăng nhập" name="submit">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
