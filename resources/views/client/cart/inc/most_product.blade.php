<div class="wrap-show-advance-info-box style-1 box-in-site">
    <h3 class="title-box">Sản phẩm phổ biến</h3>
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