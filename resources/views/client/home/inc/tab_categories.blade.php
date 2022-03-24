<div class="wrap-show-advance-info-box style-1">
    <h3 class="title-box">Product Categories</h3>
    <div class="wrap-top-banner">
        <a href="#" class="link-banner banner-effect-2">
            <figure><img src="{{ asset('clients/assets/images/kids-toy-banner.jpg') }}" width="1170"
                    height="240" alt="">
            </figure>
        </a>
    </div>
    <div class="wrap-products">
        <div class="wrap-product-tab tab-style-1">
            <div class="tab-control">
                @php
                    $a = 1;
                @endphp
                @foreach ($categories as $key => $category)
                    @if ($category->categoryChild->count() == 0)
                        <a href="#category_{{ $category->id }}"
                            class="tab-control-item {{ $a == 1 ? 'active' : '' }}">{{ $category->name }}</a>
                        @php
                            $a++;
                        @endphp
                    @endif
                @endforeach
            </div>
            <div class="tab-contents">
                @php
                    $a = 1;
                @endphp
                @foreach ($categories as $key => $category)
                    @if ($category->categoryChild->count() == 0)
                        <div class="tab-content-item {{ $a == 1 ? 'active' : '' }}"
                            id="category_{{ $category->id }}">
                            <div class="wrap-products slide-carousel owl-carousel style-nav-1 equal-container"
                                data-items="5" data-loop="false" data-nav="true" data-dots="false"
                                data-responsive='{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"3"},"992":{"items":"4"},"1200":{"items":"5"}}'>
                                @foreach ($category->products()->limit(6)->get() as $item)
                                    <div class="product product-style-2 equal-elem ">
                                        <div class="product-thumnail">
                                            <a href="detail.html" title="T-Shirt Raw Hem Organic Boro Constrast Denim">
                                                <figure><img src="{{ asset('storage/' . $item->feature_image_path) }}"
                                                        width="800" height="800"
                                                        alt="T-Shirt Raw Hem Organic Boro Constrast Denim">
                                                </figure>
                                            </a>
                                            <div class="group-flash">
                                                @if ($item->original_price)
                                                    <span class="flash-item sale-label">sale</span>
                                                @endif
                                            </div>
                                            <div class="wrap-btn">
                                                <a href="#" class="function-link">quick view</a>
                                            </div>
                                        </div>
                                        <div class="product-info">
                                            <a href="#" class="product-name"><span>{{ $item->name }}</span></a>
                                            <div class="wrap-price"><ins>
                                                    <p class="product-price">
                                                        {{ number_format($item->selling_price) }}đ</p>
                                                </ins> <del>
                                                    <p class="product-price">{{ $item->original_price }}</p>
                                                </del>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @php
                            $a++;
                        @endphp
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
