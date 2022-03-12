@extends('layouts.client')

@section('content')
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
                            <span class="product-price">{{ $product->selling_price }}</span>
                            <del>
                                <p class="product-price">{{ $product->original_price }}</p>
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
                            <a href="#" class="btn add-to-cart">Add to Cart</a>
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
                <div class="widget widget-our-services ">
                    <div class="widget-content">
                        <ul class="our-services">

                            <li class="service">
                                <a class="link-to-service" href="#">
                                    <i class="fa fa-truck" aria-hidden="true"></i>
                                    <div class="right-content">
                                        <b class="title">Miễn phí vận chuyển</b>
                                        <span class="subtitle">Cho đơn hàng từ 100k</span>
                                        <p class="desc">Tích lũy mã giảm giá qua từng đơn hàng</p>
                                    </div>
                                </a>
                            </li>

                            <li class="service">
                                <a class="link-to-service" href="#">
                                    <i class="fa fa-gift" aria-hidden="true"></i>
                                    <div class="right-content">
                                        <b class="title">Nhiều phần quà đặc biệt</b>
                                        <span class="subtitle">Cập nhật hằng tuần</span>
                                        <p class="desc">Các phần quà thường xuyên được tặng kèm theo các sản phẩm bán chạy.
                                        </p>
                                    </div>
                                </a>
                            </li>

                            <li class="service">
                                <a class="link-to-service" href="#">
                                    <i class="fa fa-reply" aria-hidden="true"></i>
                                    <div class="right-content">
                                        <b class="title">Giao hàng cực nhanh</b>
                                        <span class="subtitle">Từ 1 đến 3 ngày</span>
                                        <p class="desc">Lợi thế khi có nhiều kho, xưởng giúp các mặt hàng đến nhanh với
                                            người tiêu dùng</p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div><!-- Categories widget-->

                <div class="widget mercado-widget widget-product">
                    <h2 class="widget-title">Popular Products</h2>
                    <div class="widget-content">
                        <ul class="products">
                            @foreach ($popularProducts as $product)
                                <li class="product-item">
                                    <div class="product product-widget-style">
                                        <div class="thumbnnail">
                                            <a href="detail.html"
                                                title="Radiant-360 R6 Wireless Omnidirectional Speaker [White]">
                                                <figure><img src="{{ asset('storage/' . $product->feature_image_path) }}"
                                                        alt="{{ $product->name }}"></figure>
                                            </a>
                                        </div>
                                        <div class="product-info">
                                            <a href="#" class="product-name"><span>{{ $product->name }}</span></a>
                                            <div class="wrap-price"><span
                                                    class="product-price">{{ $product->selling_price }}</span></div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>
            <!--end sitebar-->
            @if ($relatedProducts != null)
                <div class="single-advance-box col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="wrap-show-advance-info-box style-1 box-in-site">
                        <h3 class="title-box">Related Products</h3>
                        <div class="wrap-products">
                            <div class="products slide-carousel owl-carousel style-nav-1 equal-container" data-items="5"
                                data-loop="false" data-nav="true" data-dots="false"
                                data-responsive='{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"3"},"992":{"items":"3"},"1200":{"items":"5"}}'>
                                @foreach ($relatedProducts as $product)

                                    <div class="product product-style-2 equal-elem ">
                                        <div class="product-thumnail">
                                            <a href="{{ route('product', [$product->slug, $product->id]) }}"
                                                title="T-Shirt Raw Hem Organic Boro Constrast Denim">
                                                <figure><img src="{{ asset('storage/' . $product->feature_image_path) }}"
                                                        width="800" height="800"
                                                        alt="T-Shirt Raw Hem Organic Boro Constrast Denim">
                                                </figure>
                                            </a>
                                            <div class="group-flash">
                                                <span class="flash-item new-label">new</span>
                                                @if ($product->original_price != null)
                                                    <span class="flash-item sale-label">sale</span>
                                                @endif
                                            </div>
                                            <div class="wrap-btn">
                                                <a href="#" class="function-link">quick view</a>
                                            </div>
                                        </div>
                                        <div class="product-info">
                                            <a href="#" class="product-name"><span>{{ $product->name }}</span></a>
                                            <div class="wrap-price"><ins>
                                                    <p class="product-price">{{ $product->selling_price }}</p>
                                                </ins> <del>
                                                    <p class="product-price">{{ $product->original_price }}</p>
                                                </del></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!--End wrap-products-->
                    </div>
                </div>
            @endif


        </div>
        <!--end row-->

    </div>
    <!--end container-->
@endsection
