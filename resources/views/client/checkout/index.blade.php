@extends('layouts.client')
@section('css')

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
                <div class="wrap-address-billing">
                    <h3 class="box-title">Billing Address</h3>
                    <form id="form_order">
                        <p class="row-in-form">
                            <label for="fname">Họ tên<span>*</span></label>
                            <input type="text" name="name" value="" placeholder="Nhập tên người nhận">
                        </p>
                        <p class="row-in-form">
                            <label for="add">Số điện thoại</label>
                            <input type="text" name="phone" value="" placeholder="Nhập số điện thoại người nhận">
                        </p>
                        <p class="row-in-form">
                            <label for="email">Email</label>
                            <input type="email" name="email" value=""
                                placeholder="Nhập email muốn nhận thông báo về đơn hàng">
                        </p>

                        <p class="row-in-form">
                            <label for="add">Địa chỉ</label>
                            <input type="text" name="address" value="" placeholder="Nhập địa chỉ nhận hàng">
                        </p>
                        <p class="row-in-form">
                            <label for="add">Tin nhắn</label>
                            <textarea style="width: 100%; border: 1px solid #e6e6e6; font-size: 13px;
                           line-height: 19px; padding: 12px 20px; display: inline-block; height: 50px" name="message"
                                rows="3" placeholder="VD: Giao hàng vào buổi sáng,..."></textarea>
                        </p>
                        <p class="row-in-form" style="margin-top: 22px">
                            <label class="checkbox-field">
                                <input name="payment" id="create-account" value="pay_at_home" type="radio">
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
                                <a class="btn btn-medium btn_order">Đặt hàng</a>
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

                            <div class="product product-style-2 equal-elem ">
                                <div class="product-thumnail">
                                    <a href="#" title="T-Shirt Raw Hem Organic Boro Constrast Denim">
                                        <figure><img src="assets/images/products/digital_04.jpg" width="214" height="214"
                                                alt="T-Shirt Raw Hem Organic Boro Constrast Denim"></figure>
                                    </a>
                                    <div class="group-flash">
                                        <span class="flash-item new-label">new</span>
                                    </div>
                                    <div class="wrap-btn">
                                        <a href="#" class="function-link">quick view</a>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <a href="#" class="product-name"><span>Radiant-360 R6 Wireless Omnidirectional Speaker
                                            [White]</span></a>
                                    <div class="wrap-price"><span class="product-price">$250.00</span></div>
                                </div>
                            </div>

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
                success: function(response) {

                }
			})
		})


		$(document).on('click', '.btn_order', function() {
			$('#form_order').submit()
		})

	</script>
@endsection