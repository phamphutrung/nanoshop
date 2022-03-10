@foreach ($permissionParents as $permissionParent)
    <div class="card border-primary">
        <div class="card-header bg-cyan-200 text-light">
            <div class="form-check form-check-inline">
                <input type="checkbox" class="form-check-input check_main" name=""
                    id="a_{{ $permissionParent->title }}">
                <label class="form-check-label" for="a_{{ $permissionParent->title }}">
                    Module {{ $permissionParent->name }}
                </label>
            </div>
        </div>
        <div class="card-body d-flex justify-content-between">
            @foreach ($permissionParent->permissionChilds as $permissionChild)
                <div class="form-check form-check-inline">
                    <input type="checkbox" class="form-check-input check_item"
                        {{ $permissionOfRoles->contains('id', $permissionChild->id) ? 'checked' : '' }}
                        name="permission_ids[]" id="b_{{ $permissionChild->title }}" value="{{ $permissionChild->id }}">
                    <label class="form-check-label" for="b_{{ $permissionChild->title }}">
                        {{ $permissionChild->name }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
@endforeach
<script>
    $('.check_main').on('click', function() {
        $(this).parents('.card').find('input').prop('checked', $(this).prop('checked'));
    })
</script>
