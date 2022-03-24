@foreach ($products as $key => $product)
    <li class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
        <div class="product product-style-3 equal-elem ">
            <div class="product-thumnail">
                <a href="{{ route('product', [$product->slug, $product->id]) }}" title="{{ $product->name }}">
                    <figure><img src="{{ asset('storage/' . $product->feature_image_path) }}"
                            alt="{{ $product->name }}"></figure>
                </a>
            </div>
            <div class="product-info">
                <a href="{{ route('product', [$product->slug, $product->id]) }}" class="product-name"><span
                        style="display: block; height: 5em">{{ $product->name }}</span></a>
                <div class="wrap-price"><span
                        class="product-price">{{ number_format($product->selling_price) }}đ</span>
                </div>
                <a data-id="{{ $product->id }}" class="btn add-to-cart">Add To Cart</a>
            </div>
        </div>
    </li>
@endforeach
