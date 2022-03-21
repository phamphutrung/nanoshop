<div class="card">
    <div class="card-header">
        Thông tin đơn hàng
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="" class="form-label">Ngày tạo:</label>
                    <p>{{ $order->created_at }}</p>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Phương thức thanh toán:</label>
                    <p>{{ $order->payment == 'pay_at_home' ? 'Thanh toán khi nhận hàng':'Chuyển khoản' }}</p>
                </div>
                <div class="mb-3">
                  <label for="" class="form-label">Trạng thái đơn hàng:</label>
                  <select data-id="{{ $order->id }}" id="status" class="form-control text-bold">
                    <option class="text-bold" {{ $order->status == 'Mới'? 'selected':'' }} value="Mới">Đơn hàng mới</option>
                    <option class="text-bold" {{ $order->status == 'Đã xác nhận'? 'selected':'' }} value="Đã xác nhận">Đã xác nhận</option>
                    <option class="text-bold" {{ $order->status == 'Đã xử lý'? 'selected':'' }} value="Đã xử lý">Đã xử lý</option>
                    <option class="text-bold" {{ $order->status == 'Đã gửi'? 'selected':'' }} value="Đã gửi">Đã gửi</option>
                    <option class="text-bold" {{ $order->status == 'Hoàn thành'? 'selected':'' }} value="Hoàn thành">Hoàn thành</option>
                    <option class="text-bold" {{ $order->status == 'Đã hủy'? 'selected':'' }} value="Đã hủy">Đã hủy</option>
                  </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="" class="form-label">Mã đơn hàng:</label>
                    <p>{{ $order->code }}</p>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Tổng tiền:</label>
                    <p>{{ $order->total }}đ</p>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Yêu cầu khác:</label>
                    <p>{{ $order->message }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        Thông tin người nhận
    </div>
    <div class="card-body">
        <div id="main_info_customer" class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="" class="form-label">Tên:</label>
                    <p>{{ $order->name }}</p>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Địa chỉ:</label>
                    <p>{{ $order->address }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="" class="form-label">Số điện thoại:</label>
                    <p>{{ $order->phone }}</p>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Email:</label>
                    <p>{{ $order->email }}</p>
                </div>
            </div>
        </div>
    </div>
</div>