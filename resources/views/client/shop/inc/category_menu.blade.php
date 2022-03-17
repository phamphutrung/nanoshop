<div class="widget mercado-widget categories-widget">
    <h2 class="widget-title">Danh Mục Sản Phẩm</h2>
    <div class="widget-content">
        <ul class="list_category">
            @foreach ($categoryParents as $itemParent)
                <li class="category_item">
                    <a href="{{ $itemParent->categoryChild->count() == 0 ? route('shop', ['slug' => $itemParent->slug, 'id' => $itemParent->id]) : '#' }}"
                        class="">{{ $itemParent->name }}</a>
                    @include('client.shop.inc.recursise_category', ['itemParent' => $itemParent])
                </li>
            @endforeach
        </ul>
    </div>
</div>