@extends('layouts.admin')
@section('title')
    Hồ sơ
@endsection
@section('content')
    <div class="card">
        <div class="card-header bg-cyan-200 text-light">
            <h2>Hồ sơ</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            Ảnh đại diện
                            <button class="btn btn-sm btn-info text-light float-right btn_add_avt"><i class="fa-solid fa-cloud-arrow-up"></i></button>
                            <form id="form_update" enctype="multipart/form-data">
                                @csrf
                                <input class="d-none" name="avt" type="file" onchange="loadFile(event)">
                        </div>
                        <div class="card-body">
                            <div class="mt-3 text-center" id="avt" style="min-height: 85px">
                                @if (Auth::user()->avt == null)
                                    <img style="width: 350px; height: 350px; border-radius: 50%; box-shadow: 0 0 8px rgba(0,0,0,0.2);"
                                        src="https://toigingiuvedep.vn/wp-content/uploads/2021/01/hinh-anh-cute-de-thuong-600x600.jpg" id="output">
                                @else
                                    <img style="width: 350px; height: 350px; border-radius: 50%; box-shadow: 0 0 8px rgba(0,0,0,0.2);"
                                        src="{{ asset('storage/' . Auth::user()->avt) }}" id="output">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            Thông tin cá nhân
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="" class="form-label">Họ và tên:</label>
                                <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}">
                                <small class="form-text text-danger error_name"></small>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Số điện thoại:</label>
                                <input type="text" class="form-control" name="phone" value="{{ Auth::user()->phone }}">
                                <small class="form-text text-danger error_phone"></small>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Email:</label>
                                <input type="text" class="form-control" name="email" value="{{ Auth::user()->email }}">
                                <small class="form-text text-danger error_email"></small>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Mật khẩu:</label>
                                <input type="password" class="form-control" name="password">
                                <small class="form-text text-danger error_password"></small>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Địa chỉ:</label>
                                <input type="text" class="form-control" name="address"
                                    value="{{ Auth::user()->address }}">
                                <small class="form-text text-danger error_address"></small>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Quê quán:</label>
                                <input type="text" class="form-control" name="hometown"
                                    value="{{ Auth::user()->hometown }}">
                                <small class="form-text text-danger error_hometown"></small>
                            </div>
                            <button type="submit" class="btn btn-sm btn-success btn_update"><i
                                    class="fas fa-spinner fa-spin d-none mr-2 pl-0"></i>Cập nhật</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).on('click', '.btn_add_avt', function() {
            $('input[name="avt"]').click()
        })
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).on('submit', '#form_update', function(e) {
            e.preventDefault()
            var form = this;
            $.ajax({
                url: "{{ route('account-update') }}",
                type: "post",
                processData: false,
                dataType: 'json',
                contentType: false,
                data: new FormData(form),
                beforeSend: function() {
                    $('small.text-danger').text('')
                    $('.btn_update i').removeClass('d-none')
                },
                success: function(res) {
                    $('.btn_update i').addClass('d-none')
                    if (res.code == 0) {
                        $.each(res.error, function(key, val) {
                            $('small.error_' + key).text(val)
                        })
                    } else {
                        alertify.success(res.msg)
                    }
                }
            })
        })

        function loadFile(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('output');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        };

    </script>
@endsection
