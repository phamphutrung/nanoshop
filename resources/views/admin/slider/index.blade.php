@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>
@endsection
@section('scripts')
    <script>
        function loadFile(event) {
            var reader = new FileReader();
            reader.onload = function(){
              var output = document.getElementById('output');
              output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
          };
    </script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
        $('#form').on('submit', function(e){
            e.preventDefault();
            var form = this
            $.ajax({
                url: "{{ route('admin-slider-add') }}",
                type: "post",
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(form).find('span.error-text').text('');
                    $(form).find('#submit-btn').prop('disabled', true)
                    $(form).find('#submit-btn i').removeClass('d-none')
                },
                success: function (response) {
                    $(form).find('#submit-btn').prop('disabled', false);
                    $(form).find('#submit-btn i').addClass('d-none')
                    if(response.code == 0) {
                        $.each(response.error, function (index, val) {
                            $(form).find('span.slider_'+index+'_error').text(val);
                        })
                    } else {
                        $("#exampleModal").slideUp(300, function(){
                            $("#exampleModal").modal('hide');
                        });
                        $('#output').prop('src', '')
                        $(form)[0].reset();
                        alertify.success(response.message);
                    }
                }
            })
        })
    </script>
    
@endsection


@section('content')
   
    <div class="row" style="padding-top: 15px">
        <div class="col-md-12">
            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-regular fa-square-plus mr-2" ></i>Thêm slider</button>
        </div>
        <div class="col-md-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Ảnh</th>
                        <th>Tiêu đề</th>
                        <th>hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">New message</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="form" enctype="multipart/form-data">
            @csrf
          <div class="modal-body">
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Ảnh:</label>
                <input onchange="loadFile(event)" type="file" class="form-control" name="image" id="data_image">
                <span class="text-danger error-text slider_image_error"></span>
                <div class="text-center mt-3">
                    <img style="max-width: 500px; border-radius: 10px; box-shadow: 0 0 8px rgba(0,0,0,0.2);" id="output" src="" alt="">
                </div>
              </div>
              <div class="mb-3">
                <label for="recipient-name" class="col-form-label">Tiêu đề:</label>
                <input type="text" class="form-control" name="title" id="data_title">
                <span class="text-danger error-text slider_title_error"></span>

              </div>
              <div class="mb-3">
                <label for="message-text" class="col-form-label">Mô tả:</label>
                <textarea class="form-control" name="description" id="data_description"></textarea>
                <span class="text-danger error-text slider_description_error"></span>

              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="submit-btn" type="submit"  class="btn btn-primary"><i class="fas fa-spinner fa-spin d-none"></i> Send message</button>
            </div>
        </form>
        </div>
      </div>
    </div>
  
@endsection

