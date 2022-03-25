@foreach ($productItems as $productItem)
    <tr>
        <td>
            <img style="width: 3em; height: 3em;" src="{{ asset('storage/'.$productItem->feature_image_path) }}">
        </td>
        <td>{{ $productItem->name }}</td>
        <td>{{ number_format($productItem->selling_price) }}đ</td>
        <td>{{ $productItem->pivot->qty }}</td>
        <td>{{ number_format($productItem->pivot->total) }}đ</td>
    </tr>
@endforeach
