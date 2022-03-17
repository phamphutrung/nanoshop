<div style="margin-top: 8.2em" class="widget mercado-widget widget-product">
    <h2 class="widget-title">Sản Phẩm Phổ Biến</h2>
    <div class="widget-content">
        <ul class="products">
            @foreach ($popularProducts as $item)
                <li class="product-item">
                    <div class="product product-widget-style">
                        <div class="thumbnnail">
                            <a href="detail.html"
                                title="Radiant-360 R6 Wireless Omnidirectional Speaker [White]">
                                <figure><img src="{{ asset('storage/'.$item->feature_image_path) }}" alt="">
                                </figure>
                            </a>
                        </div>
                        <div class="product-info">
                            <a href="#" class="product-name"><span>{{ $item->name }}</span></a>
                            <div class="wrap-price"><span class="product-price">{{ number_format($item->selling_price) }}đ</span></div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div><!-- brand widget-->