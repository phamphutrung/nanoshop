@extends('layouts.client')

@section('content')
    <style>
        .order-summary {
            width: 50em;
        }

    </style>
    <div class="container">

        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="#" class="link">home</a></li>
                <li class="item-link"><span>login</span></li>
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
                                        <a class="link-to-product" href="#">{{ $product->name }}</a>
                                    </div>
                                    <div class="price-field produtc-price">
                                        <p class="price">{{ $product->price }}</p>
                                    </div>
                                    <div class="quantity">
                                        <div class="quantity-input">
                                            <input readonly class="qty_item" data-id="{{ $product->rowId }}" type="text"
                                                name="product-quatity" value="{{ $product->qty }}" data-max="120"
                                                pattern="[0-9]*">
                                            <a class="btn btn-increase change_qty_item"></a>
                                            <a class="btn btn-reduce change_qty_item"></a>
                                        </div>
                                    </div>
                                    <div class="price-field sub-total">
                                        <p class="price itemTotal{{ $product->rowId }}">{{ $product->total }}</p>
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
                                    class="index cartTotal">{{ Cart::total() }}</b></p>
                            <p class="summary-info"><span class="title">Shipping</span><b class="index">Free Shipping</b>
                            </p>
                            <p class="summary-info total-info "><span class="title">Total</span><b
                                    class="index cartTotal">{{ Cart::total() }}</b></p>
                        </div>
                        <div class="checkout-info" style="margin-left: 20em">
                            <label class="checkbox-field">
                                <input class="frm-input " name="have-code" id="have-code" value="" type="checkbox"><span>I
                                    have
                                    promo code</span>
                            </label>
                            <a class="btn btn-checkout" href="checkout.html">Check out</a>
                            <a class="link-to-shop" href="shop.html">Continue Shopping<i class="fa fa-arrow-circle-right"
                                    aria-hidden="true"></i></a>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning" role="alert">
                        <h4 class="alert-heading">Giỏ hàng rỗng</h4>
                        <p>Bạn chưa thêm bất kì sản phẩm nào vào giỏ hàng</p>
                        <hr>
                        <p class="mb-0"> <a class="link-to-shop" href="">Tiếp tục mua sắm<i style="margin-left: 0.5rem"
                                    class="fa fa-arrow-circle-right" aria-hidden="true"></i></a></p>
                    </div>
                @endif
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
                                    <a href="{{ route('product', [$itemProduct->slug, $itemProduct->id]) }}" title="T-Shirt Raw Hem Organic Boro Constrast Denim">
                                        <figure><img src="{{ asset('storage/'. $itemProduct->feature_image_path) }}" width="214"
                                                height="214" alt="{{ $itemProduct->name }}"></figure>
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
                                    <a href="{{ route('product', [$itemProduct->slug, $itemProduct->id]) }}" class="product-name"><span>{{ $itemProduct->name }}</span></a>
                                    <div class="wrap-price"><ins>
                                            <p class="product-price">{{ number_format($itemProduct->selling_price) }}đ</p>
                                        </ins> <del>
                                            <p class="product-price">{{ $itemProduct->original_price }}đ</p>
                                        </del></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!--End wrap-products-->
            </div>

        </div>
        <!--end main content area-->
    </div>
    <!--end container-->
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
                    $('#cartItem' + rowId).remove();
                    var length = $('.products-cart').find('li').length;
                    if (length < 1) {
                        $('#main_data').html(response.noti)
                    }
                    $('#cartCount').text(response.cartCount + " " + "SP")
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
                    $('.itemTotal' + rowId).text(response.itemTotal);
                    $('.cartTotal').text(response.cartTotal);
                    $('#cartCount').text(response.cartCount + " " + "SP")
                }
            })
        })
        $(document).on('change', '.qty_item', function() {
            var qty = $(this).val();
            var rowId = $(this).data('id');
            $.ajax({
                url: "{{ route('cart-update-item') }}",
                type: "post",
                data: {
                    qty: qty,
                    rowId: rowId
                },
                dataType: 'json',
                success: function(response) {
                    $('.itemTotal' + rowId).text(response.itemTotal);
                    $('.cartTotal').text(response.cartTotal);
                    $('#cartCount').text(response.cartCount)
                }
            })
        })

    </script>
@endsection
