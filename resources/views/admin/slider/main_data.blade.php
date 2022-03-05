@if ($sliders->count() > 0)
    @foreach ($sliders as $slider)
        <tr id="slider-{{ $slider->id }}">
            <td class="text-center">
                <input data-id="{{ $slider->id }}" name="item_check" type="checkbox">
            </td>
            <td class="text-center">
                <img id="image_show" src="{{ asset('storage/') . '/' . $slider->image_path }}">
            </td>
            <td>{!! $slider->title !!}</td>
            <td>{!! $slider->description !!}</td>
            <td class="text-center">
                <div class="form-check form-switch">
                    <input {{ $slider->active == 'on' ? 'checked' : '' }} class="form-check-input active_check"
                        data-id="{{ $slider->id }}" type="checkbox" id="flexSwitchCheckChecked">
                </div>
            </td>
            <td class="text-center">
                <button data-id="{{ $slider->id }}" class="btn-primary btn btn-edit" data-bs-toggle="modal"
                    data-bs-target="#modal_edit"><i class="fas fa-edit"></i></button>
                <button data-id="{{ $slider->id }}" class="btn-danger btn btn-delete"><i
                        class="fas fa-ban"></i></button>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="6">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <strong>Không tìm thấy kết quả nào.</strong>
            </div>
        </td>
    </tr>
@endif
