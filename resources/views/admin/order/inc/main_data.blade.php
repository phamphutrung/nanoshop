@if ($orders->count() > 0)
@foreach ($orders as $order)
    <tr id="order-{{ $order->id }}">
        <td class="text-bold text-danger">{{ $order->code }}</td>
        <td>{{ $order->created_at }}</td>
        <td>{{ $order->name }}</td>
        <td class="text-bold">{{ $order->total }}đ</td>
        <td>
            <span class="badge 
                        @php
                            if ($order->status == 'Mới') {
                                echo 'bg-warning';
                            } elseif ($order->status == 'Đã xác nhận') {
                                echo 'bg-primary';
                            } elseif ($order->status == 'Đã xử lý') {
                                echo 'bg-info';
                            } elseif ($order->status == 'Đã gửi') {
                                echo 'bg-secondary';
                            } elseif ($order->status == 'Hoàn thành') {
                                echo 'bg-success';
                            } elseif ($order->status == 'Đã hủy') {
                                echo 'bg-danger';
                            }
                        @endphp">
                {{ $order->status }}
            </span>
        </td>
        <td>
            <button data-id="{{ $order->id }}"
                class="btn btn-sm btn-info mr-1 text-light btn_detail"
                data-bs-toggle="modal" data-bs-target="#model_detail_order"><i
                    class="fa-regular fa-eye"></i></button>
            <button data-id="{{ $order->id }}" class="btn btn-sm btn-danger btn_delete"><i class="fa-solid fa-trash"></i></button>
        </td>
    </tr>
@endforeach
@else
<tr>
    <td colspan="6">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert"
                aria-label="Close"></button>
            <strong>Không tìm thấy đơn hàng nào</strong>
        </div>
    </td>
</tr>
@endif