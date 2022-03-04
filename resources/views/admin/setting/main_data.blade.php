@foreach ($settings as $setting)
<tr id="setting_{{ $setting->id }}">
    <td class="text-center">
        <input data-id="{{ $setting->id }}" name="item_check" type="checkbox">
    </td>
    <td>{!! $setting->config_key !!}</td>
    <td>{!! $setting->config_value !!}</td>
    <td class="d-flex">
        <button data-id="{{ $setting->id }}" class="btn-primary btn btn_edit mr-2"
            data-bs-toggle="modal" data-bs-target="#edit_config"><i
                class="fas fa-edit"></i></button>
        <button data-id="{{ $setting->id }}" class="btn-danger btn btn-delete"><i
                class="fas fa-ban"></i></button>
    </td>
</tr>
@endforeach
{{ $settings->links() }}
