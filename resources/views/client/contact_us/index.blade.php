@extends('layouts.client')
@section('content')
@section('title')
    Tin nhắn
@endsection
@section('scripts')
    <script>
         $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        $(document).on('submit', '#form_message', function(e) {
            e.preventDefault()
            var form = this;
            $.ajax({
                url: "{{ route('contact-send') }}",
                type: 'post',
                processData: false,
                contentType: false,
                data: new FormData(form),
                dataType: 'json',
                beforeSend: function() {
                    $('small.text-danger').text('')
                },             
                success: function(res) {
                    if (res.code == 0) {
                        $.each(res.error, function(index, val) {
                            $('small.error_' + index).text(val)
                        })
                    } else {
                        $('input, textarea').val('')
                        alertify.success(res.msg)
                    }
                }
            })
        })

    </script>
@endsection
<main id="main" class="main-site left-sidebar">
    <div class="container">
        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="#" class="link">Trang chủ</a></li>
                <li class="item-link"><span>Liên hệ</span></li>
            </ul>
        </div>
        <div class="row">
            <div class=" main-content-area">
                <div class="wrap-contacts ">
                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                        <div class="contact-box contact-form">
                            <h2 class="box-title">Để lại lời nhắn cho chúng tôi</h2>
                            <form id="form_message">
                                @csrf
                                <div style="margin-bottom: 0.8rem">
                                    <label for="name">Tên<span>*</span></label>
                                    <input type="text" value="" id="name" name="name">
                                    <small class="text-danger error_name"></small>
                                </div>
                                <div style="margin-bottom: 0.8rem">
                                    <label for="email">Email<span>*</span></label>
                                    <input type="text" value="" id="email" name="email">
                                    <small class="text-danger error_email"></small>
                                </div>
                                <div style="margin-bottom: 0.8rem">
                                    <label for="phone">Số điện thoại</label>
                                    <input type="text" value="" id="phone" name="phone">
                                </div>
                                <div style="margin-bottom: 0.8rem">
                                    <label for="comment">Tin nhắn<span>*</span></label>
                                    <textarea name="message" id="comment"></textarea>
                                    <small class="text-danger error_message"></small>
                                </div>

                                <button type="submit" class="btn btn-danger btn_send">Gửi</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                        <div class="contact-box contact-info">
                            <div class="wrap-map">
                                <div class="mercado-google-maps" id="az-google-maps57341d9e51968" data-hue=""
                                    data-lightness="1" data-map-style="2" data-saturation="-100"
                                    data-modify-coloring="false" data-title_maps="Kute themes"
                                    data-phone="088-465 9965 02" data-email="kutethemes@gmail.com"
                                    data-address="Z115 TP. Thai Nguyen" data-longitude="-0.120850"
                                    data-latitude="51.508742" data-pin-icon="" data-zoom="16" data-map-type="ROADMAP"
                                    data-map-height="263">
                                </div>
                            </div>
                            <h2 class="box-title">Chi tiết liên hệ</h2>
                            <div class="wrap-icon-box">

                                <div class="icon-box-item">
                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                    <div class="right-info">
                                        <b>Email</b>
                                        <p>{{ getConfigValue('email') }}</p>
                                    </div>
                                </div>

                                <div class="icon-box-item">
                                    <i class="fa fa-phone" aria-hidden="true"></i>
                                    <div class="right-info">
                                        <b>Số điện thoại</b>
                                        <p>{{ getConfigValue('phone') }}</p>
                                    </div>
                                </div>

                                <div class="icon-box-item">
                                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                                    <div class="right-info">
                                        <b>Địa chỉ</b>
                                        <p>{{ getConfigValue('address') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
