<div class="widget mercado-widget widget-product">
    <h2 class="widget-title">Popular Products</h2>
    <div class="widget-content">
        <ul class="products">
            @foreach ($popularProducts as $product)
                <li class="product-item">
                    <div class="product product-widget-style">
                        <div class="thumbnnail">
                            <a href="{{ route('product', [$product->slug, $product->id]) }}"
                                title="Radiant-360 R6 Wireless Omnidirectional Speaker [White]">
                                <figure><img src="{{ asset('storage/' . $product->feature_image_path) }}"
                                        alt="{{ $product->name }}"></figure>
                            </a>
                        </div>
                        <div class="product-info">
                            <a href="{{ route('product', [$product->slug, $product->id]) }}" class="product-name"><span>{{ $product->name }}</span></a>
                            <div class="wrap-price"><span
                                    class="product-price">{{ $product->selling_price }}đ</span></div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>