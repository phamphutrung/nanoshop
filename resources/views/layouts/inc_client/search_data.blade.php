<div class="card">
    <ul class="list-group list-group-flush">
        @if ($products->count() > 0)
            @foreach ($products as $product)
                <li class="list-group-item text-left">
                    <a href="{{ route('product', [$product->slug, $product->id]) }}">
                        <div class="row">
                            <div class="col-md-2 col-sm-4">
                                <img style="width:100px; height: auto;"
                                    src="{{ asset('storage/' . $product->feature_image_path) }}" alt="">
                            </div>
                            <div class="col-md-10">
                                <p>{{ $product->name }}</p>
                            </div>
                        </div>
                    </a>
                </li>
            @endforeach
        @else
            <p style="margin-top: 1em"><strong>Không tìm thấy sản phẩm nào</strong></p>
        @endif

    </ul>
</div>
