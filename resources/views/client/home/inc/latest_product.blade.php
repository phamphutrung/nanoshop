<div class="wrap-show-advance-info-box style-1">
    <h3 class="title-box">Sản Phẩm Mới</h3>
    <div class="wrap-top-banner">
        <a href="#" class="link-banner banner-effect-2">
            <figure><img src="{{ asset('clients/assets/images/digital-electronic-banner.jpg') }}" width="1170"
                    height="240" alt="">
            </figure>
        </a>
    </div>
    <div class="wrap-products">
        <div class="wrap-product-tab tab-style-1">
            <div class="tab-contents">
                <div class="tab-content-item active" id="digital_1a">
                    <div class="wrap-products slide-carousel owl-carousel style-nav-1 equal-container"
                        data-items="5" data-loop="false" data-nav="true" data-dots="false"
                        data-responsive='{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"3"},"992":{"items":"4"},"1200":{"items":"5"}}'>
                        @foreach ($lastProducts as $product)

                            <div class="product product-style-2 equal-elem ">
                                <div class="product-thumnail">
                                    <a href="{{ route('product', [$product->slug, $product->id]) }}"
                                        title="T-Shirt Raw Hem Organic Boro Constrast Denim">
                                        <figure><img
                                                src="{{ asset('storage/' . $product->feature_image_path) }}"
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
                                            <p class="product-price">
                                                {{ number_format($product->selling_price) }}đ</p>
                                        </ins> <del>
                                            <p class="product-price">{{ $product->original_price }}đ</p>
                                        </del></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>