@if ($products->count() > 0)
    @foreach ($products as $key => $product)
        <tr id="product-{{ $product->id }}">

            <td class="text-center">
                <img style="width: 5rem; height: 5rem; border-radius: 10px; box-shadow: 0 0 8px rgba(0,0,0,0.2);"
                    src="{{ asset('storage/' . $product->feature_image_path) }}" alt="ảnh đại diện">
            </td class="text-center">
            <td class="center">{{ $product->created_at }} </td>
            <td data-toggle="tooltip" data-placement="top" title="Xem chi tiết"
                class="text-center text-bold text-capitalize productItem text-primary" data-id="{{ $product->id }}"
                style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#exampleModal">
                {{ $product->name }}</td>

            <td class="text-center"> {{ number_format($product->selling_price) }}đ </td>

            <td class="text-center">
                {{-- {{ $product->category ? $product->category->name : '' }} --}}
                <span class="badge bg-warning text-dark">{{ optional($product->category)->name }}</span>

            </td>

            <td class="text-center">
                <div class="form-check form-switch">
                    <input {{ $product->trending == 1 ? 'checked' : '' }} class="form-check-input trending_check"
                        data-id="{{ $product->id }}" type="checkbox" id="flexSwitchCheckChecked">
                </div>
            </td>

            <td class="text-center">
                <div class="form-check form-switch">
                    <input {{ $product->status == 1 ? 'checked' : '' }} class="form-check-input status_check"
                        data-id="{{ $product->id }}" type="checkbox" id="flexSwitchCheckChecked">
                </div>
            </td>
            <td class="text-center">
                <a data-toggle="tooltip" data-placement="top" title="Chỉnh sửa" class="btn btn-primary btn-sm"
                    href="{{ route('admin-product-edit', [$product->id]) }}">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <button data-id="{{ $product->id }} " data-toggle="tooltip" data-placement="top" title="Xóa"
                    class="btn btn-danger btn-sm btn_delete">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="8">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>Không tìm thấy sản phẩm nào</strong>
            </div>
        </td>
    </tr>
@endif
<div class="mt-2 d-flex justify-content-end">{{ $products->links() }}</div>
