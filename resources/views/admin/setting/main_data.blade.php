@if ($settings->count() > 0)
    @foreach ($settings as $setting)
        <tr id="setting_{{ $setting->id }}">
            <td class="text-center">
                <input data-id="{{ $setting->id }}" name="item_check" type="checkbox">
            </td>
            <td>{!! $setting->config_key !!}</td>
            <td>{!! $setting->config_value !!}</td>
            <td class="d-flex justify-content-center">
                <button data-id="{{ $setting->id }}" class="btn-primary btn btn_edit mr-2 btn-sm" data-bs-toggle="modal"
                    data-bs-target="#edit_config"><i class="fas fa-edit"></i></button>
                <button data-id="{{ $setting->id }}" class="btn-danger btn btn-delete btn-sm"><i
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
