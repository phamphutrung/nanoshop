@extends('layouts.client')
@section('title', 'Đặt hàng')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
@section('content')
    <main id="main" class="main-site">
        <div class="container">
            <div class="wrap-breadcrumb">
                <ul>
                    <li class="item-link"><a href="{{ route('home') }}" class="link">Trang chủ</a></li>
                    <li class="item-link"><a href="{{ route('cart') }}" class="link">Giỏ hàng</a></li>
                    <li class="item-link"><a class="link">Đặt hàng</a></li>
                </ul>
            </div>
            <div class=" main-content-area">
                <div id="main_data">
                    <div class="wrap-address-billing">
                        <h3 class="box-title">Billing Address</h3>
                        <form id="form_order">
                            <p class="row-in-form">
                                <label>Họ tên<span>*</span></label>
                                <input type="text" name="name" value="" placeholder="Nhập tên người nhận">
                                <span class="text-danger error_name"></span>
                            </p>
                            <p class="row-in-form">
                                <label for="add">Số điện thoại</label>
                                <input type="text" name="phone" value="" placeholder="Nhập số điện thoại người nhận">
                                <span class="text-danger error_phone"></span>
                            </p>
                            <p class="row-in-form">
                                <label for="email">Email</label>
                                <input type="email" name="email" value=""
                                    placeholder="Nhập email muốn nhận thông báo về đơn hàng">
                                <span class="text-danger error_email"></span>
                            </p>

                            <p class="row-in-form">
                                <label for="add">Địa chỉ</label>
                                <input type="text" name="address" value="" placeholder="Nhập địa chỉ nhận hàng">
                                <span class="text-danger error_address"></span>
                            </p>
                            <p class="row-in-form">
                                <label for="add">Tin nhắn</label>
                                <textarea style="width: 100%; border: 1px solid #e6e6e6; font-size: 13px;
                                           line-height: 19px; padding: 12px 20px; display: inline-block; height: 50px"
                                    name="message" rows="3" placeholder="VD: Giao hàng vào buổi sáng,..."></textarea>
                            </p>
                            <p class="row-in-form" style="margin-top: 22px">
                                <label class="checkbox-field">
                                    <input name="payment" id="create-account" value="pay_at_home" type="radio" checked>
                                    <span style="color: #555555;">Thanh toán khi nhận hàng</span>
                                </label>
                                <label class="checkbox-field">
                                    <input name="payment" id="different-add" value="pay_onl" type="radio">
                                    <span style="color: #555555;">Chuyển khoản</span>
                                </label>
                            </p>
                            @csrf

                        </form>
                    </div>
                    <div class="summary summary-checkout">
                        <div class="summary-item shipping-method">
                            <h4 class="title-box">Thông tin đơn hàng</h4>
                            <div>
                                <table class="table table-sm table-inverse table-inverse table-hover table-responsive">
                                    <thead class="thead-inverse">
                                        <tr>
                                            <th>Tên</th>
                                            <th>Giá</th>
                                            <th>Số lượng</th>
                                            <th>Tổng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (Cart::content() as $product)
                                            <tr>
                                                <td>
                                                    <img style="width: 4em; height: 4em; margin-right: 5px;"
                                                        src="{{ asset('storage/' . $product->options->avt) }}" alt="">
                                                    {{ $product->name }}
                                                </td>
                                                <td>{{ number_format($product->price) }}</td>
                                                <td>x<span>{{ $product->qty }}</span></td>
                                                <td>{{ number_format($product->total) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div style="display: flex; justify-content: end">
                                <div style="margin-right: 5em">
                                    <p class="summary-info grand-total"><span>Tổng Đơn Hàng</span> <span
                                            class="grand-total-price">{{ Cart::total() }}đ</span></p>
                                    <a class="btn btn-medium btn_order"><i id="load_order" style="margin-right: 0.6em; display: none;"
                                        class="fas fa-spinner fa-spin d-none pl-0"></i>Đặt hàng</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="wrap-show-advance-info-box style-1 box-in-site">
                    <h3 class="title-box">Most Viewed Products</h3>
                    <div class="wrap-products">
                        <div class="products slide-carousel owl-carousel style-nav-1 equal-container" data-items="5"
                            data-loop="false" data-nav="true" data-dots="false"
                            data-responsive='{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"3"},"992":{"items":"3"},"1200":{"items":"5"}}'>

                            @foreach ($popularProducts as $itemProduct)
                                <div class="product product-style-2 equal-elem ">
                                    <div class="product-thumnail">
                                        <a href="{{ route('product', [$itemProduct->slug, $itemProduct->id]) }}"
                                            title="T-Shirt Raw Hem Organic Boro Constrast Denim">
                                            <figure><img src="{{ asset('storage/' . $itemProduct->feature_image_path) }}"
                                                    width="214" height="214" alt="{{ $itemProduct->name }}"></figure>
                                        </a>
                                        <div class="group-flash">
                                            @if ($itemProduct->original_price)
                                                <span class="flash-item sale-label">sale</span>
                                            @endif
                                        </div>
                                        <div class="wrap-btn">
                                            <a href="#" class="function-link">quick view</a>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <a href="{{ route('product', [$itemProduct->slug, $itemProduct->id]) }}"
                                            class="product-name"><span>{{ $itemProduct->name }}</span></a>
                                        <div class="wrap-price"><ins>
                                                <p class="product-price">
                                                    {{ number_format($itemProduct->selling_price) }}đ</p>
                                            </ins> <del>
                                                <p class="product-price">{{ $itemProduct->original_price }}đ</p>
                                            </del></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('scripts')
    <script>
        $(document).on('submit', '#form_order', function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: "{{ route('order') }}",
                type: 'post',
                processData: false,
                contentType: false,
                data: new FormData(form),
                dataType: 'json',
                beforeSend: function() {
                    $('#load_order').css('display', 'inline-block')
                    $('.btn_order').css('cursor', 'not-allowed')
                },
                success: function(response) {
                    $('#load_order').css('display', 'none')
                    $('.btn_order').css('cursor', 'default')
                    if (response.code == -1) {
                        alertify.warning(response.msg)
                    } else {
                        if (response.code == 0) {
                        $.each(response.errors, function(index, val) {
                            $('span.error_' + index).text(val)
                        })
                    } else {
                        $('#main_data').html(response.view)
                        alertify.success('Đặt hàng thành công')
                        $('#cartCount').text('0 SP')
                        $(window).scrollTop(0)
                    }
                    }
                }
            })
        })


        $(document).on('click', '.btn_order', function() {
            $('#form_order').submit()
        })

        $(window).on('scroll', function(){
            console.log($(document).height() + " " + $(document).scrollTop()) 
        })
    </script>
@endsection
