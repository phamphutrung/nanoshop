@extends('layouts.client')
@section('title', 'Giỏ hàng')
@section('content')
    <style>
        .order-summary {
            width: 50em;
        }

    </style>
    <main id="main" class="main-site">
        <div class="container">

            <div class="wrap-breadcrumb">
                <ul>
                    <li class="item-link"><a href="{{ route('home') }}" class="link">Trang chủ</a></li>
                    <li class="item-link"><span>Giỏ hàng</span></li>
                </ul>
            </div>
            <div class=" main-content-area">
                <div id="main_data">

                    @if (Cart::count() > 0)
                        <div class="wrap-iten-in-cart">
                            <h3 class="box-title">Products Name</h3>
                            <ul class="products-cart">
                                @foreach (Cart::content() as $product)
                                    <li class="pr-cart-item" id="cartItem{{ $product->rowId }}">
                                        <div class="product-image">
                                            <figure><img src="{{ asset('storage/' . $product->options->avt) }}" alt="">
                                            </figure>
                                        </div>
                                        <div class="product-name">
                                            <a class="link-to-product" href="{{ route('product', [$product->options->slug, $product->id]) }}">{{ $product->name }}</a>
                                        </div>
                                        <div class="price-field produtc-price">
                                            <p class="price">{{ number_format($product->price) }}đ</p>
                                        </div>
                                        <div class="quantity">
                                            <div class="quantity-input">
                                                <input readonly class="qty_item" data-id="{{ $product->rowId }}"
                                                    type="text" name="product-quatity" value="{{ $product->qty }}"
                                                    data-max="120" pattern="[0-9]*">
                                                <a class="btn btn-increase change_qty_item"></a>
                                                <a class="btn btn-reduce change_qty_item"></a>
                                            </div>
                                        </div>
                                        <div class="price-field sub-total">
                                            <p class="price itemTotal{{ $product->rowId }}">
                                                {{ number_format($product->total) }}<span>đ</span></p>
                                        </div>
                                        <div class="delete">
                                            <a data-id="{{ $product->rowId }}" class="btn btn_delete_item" title="">
                                                <span>Delete from your cart</span>
                                                <i class="fa fa-times-circle" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div style="display: flex; align-items: center" class="summary">
                            <div class="order-summary">
                                <h4 class="title-box">Order Summary</h4>
                                <p class="summary-info"><span class="title">Subtotal</span><b
                                        class="index cartTotal">{{ Cart::total() }}đ</b></p>
                                <p class="summary-info"><span class="title">Shipping</span><b class="index">Free
                                        Shipping</b>
                                </p>
                                <p class="summary-info total-info "><span class="title">Total</span><b
                                        class="index cartTotal">{{ Cart::total() }}đ</b></p>
                            </div>
                            <div class="checkout-info" style="margin-left: 20em; width:40em">
                                <a class="btn btn-checkout" href="{{ route('checkout') }}">Đặt hàng</a>
                                <a class="link-to-shop" href="shop.html">Tiếp tục mua sắm<i
                                        class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning" role="alert">
                            <h4 class="alert-heading">Giỏ hàng rỗng</h4>
                            <p>Bạn chưa thêm bất kì sản phẩm nào vào giỏ hàng</p>
                            <hr>
                            <p class="mb-0"> <a class="link-to-shop" href="{{ route('shop') }}">Tiếp tục mua sắm<i
                                        style="margin-left: 0.5rem" class="fa fa-arrow-circle-right"
                                        aria-hidden="true"></i></a></p>
                        </div>
                    @endif
                </div>
                @include('client.cart.inc.most_product')
            </div>
        </div>
    </main>

@endsection
@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).on('click', '.btn_delete_item', function() {
            var rowId = $(this).data('id');
            // alert(rowId)
            $.ajax({
                url: "{{ route('cart-delete-item') }}",
                type: 'get',
                dataType: 'json',
                data: {
                    rowId: rowId
                },
                success: function(response) {
                    $('#cartItem' + rowId).fadeOut(500, function() {
                        $(this).remove()
                    });

                    function noti() {
                        var length = $('.products-cart').find('li').length;
                        if (length < 1) {
                            $('#main_data').html(response.noti)
                        }
                    }
                    $('#cartCount').text(response.cartCount + " " + "SP")

                    setTimeout(() => {
                        noti()
                    }, 550);

                }
            })
        })
        $(document).on('click', '.change_qty_item', function() {
            var qty = $(this).parent().find('input').val();
            var rowId = $(this).parent().find('input').data('id');
            $.ajax({
                url: "{{ route('cart-update-item') }}",
                type: "post",
                data: {
                    qty: qty,
                    rowId: rowId
                },
                dataType: 'json',
                success: function(response) {
                    $('.itemTotal' + rowId).text(number_format(response.itemTotal) + 'đ');
                    $('.cartTotal').text(response.cartTotal + 'đ');
                    $('#cartCount').text(response.cartCount + " " + "SP")
                }
            })
        })

        function number_format(number, decimals, dec_point, thousands_sep) {
            // Strip all characters but numerical ones.
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }

    </script>
@endsection
