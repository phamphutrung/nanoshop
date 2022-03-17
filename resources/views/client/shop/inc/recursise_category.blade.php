@if ($itemParent->categoryChild->count())
<i class="fa-solid fa-circle-chevron-down show_child_cat"></i>
<ul class="list_sub_category">
    @foreach ($itemParent->categoryChild as $itemChild)
        <li class="category_item">
            <a href="{{ route('shop', ['slug' => $itemChild->slug, 'id' => $itemChild->id]) }}" class="">{{ $itemChild->name }}</a>
            @include('client.shop.inc.recursise_category', ['itemParent' => $itemChild])
        </li>
    @endforeach
</ul>
@endif