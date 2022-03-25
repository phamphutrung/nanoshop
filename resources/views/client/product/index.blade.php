@extends('layouts.client')
@section('title')
    {{ $product->name }}
@endsection
@section('content')
    <main id="main" class="main-site">
        <div class="container">

            <div class="wrap-breadcrumb">
                <ul>
                    <li class="item-link"><a href="#" class="link">home</a></li>
                    <li class="item-link"><span>detail</span></li>
                </ul>
            </div>
            <div class="row">

                <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12 main-content-area">
                    <div class="wrap-product-detail">
                        <div class="detail-media">
                            <div class="product-gallery">
                                <ul class="slides">
                                    @foreach ($product->product_images as $product_image)
                                        <li data-thumb="{{ asset('storage/' . $product_image->image_path) }} ">
                                            <img src="{{ asset('storage/' . $product_image->image_path) }}"
                                                alt="product thumbnail" />
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="detail-info">

                            <h2 class="product-name">{{ $product->name }}</h2>
                            <div class="short-desc">
                                {!! $product->description !!}
                            </div>
                            <div class="wrap-social">
                                <a class="link-socail" href="#"><img src="assets/images/social-list.png" alt=""></a>
                            </div>
                            <div class="wrap-price">
                                <span class="product-price">{{ number_format($product->selling_price) }}đ</span>
                                <del>
                                    <p class="product-price">{{ $product->original_price }}đ</p>
                                </del>
                            </div>
                            <div class="stock-info in-stock">
                                <p class="availability">Tình trạng: <b>Còn hàng</b></p>
                            </div>
                            <div class="quantity">
                                <span>Quantity:</span>
                                <div class="quantity-input">
                                    <input type="text" name="product-quatity" value="1" data-max="120" pattern="[0-9]*">
                                    <a class="btn btn-reduce"></a>
                                    <a class="btn btn-increase"></a>
                                </div>
                            </div>
                            <div class="wrap-butons">
                                <a data-id="{{ $product->id }}" class="btn add-to-cart">Add to Cart</a>
                                <div class="wrap-btn">
                                    <a href="#" class="btn btn-compare">Add Compare</a>
                                    <a href="#" class="btn btn-wishlist">Add Wishlist</a>
                                </div>
                            </div>
                        </div>
                        <div class="advance-info">
                            <div class="tab-control normal">
                                <a href="#description" class="tab-control-item active">description</a>
                            </div>
                            <div class="tab-contents">
                                <div class="tab-content-item active" id="description">
                                    {!! $product->content !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end main products area-->

                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 sitebar">
                    @include('client.product.inc.special_service')
                    @include('client.product.inc.popular_products')
                </div>
                @include('client.product.inc.related_products')
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
        $(function() {
            $(document).on('click', '.add-to-cart', function() {
                var qty = $('input[name="product-quatity"]').val();
                var idProduct = $(this).data('id');
                $.ajax({
                    url: "{{ route('product-add-cart') }}",
                    dataType: 'json',
                    data: {
                        qty: qty,
                        idProduct: idProduct
                    },
                    success: function(response) {
                        $('#cartCount').text(response.cartCount + " " + "SP")
                        alertify.success(response.msg)
                    }
                })
            })
        })

    </script>
@endsection
