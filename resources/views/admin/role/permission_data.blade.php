@foreach ($permissionParents as $permissionParent)
    <div class="card border-primary">
        <div class="card-header bg-cyan-200 text-light">
            <div class="form-check form-check-inline">
                <input type="checkbox" class="form-check-input" name="" id="{{ $permissionParent->name }}">
                <label class="form-check-label" for="{{ $permissionParent->name }}">
                    Module {{ $permissionParent->name }}
                </label>
            </div>
        </div>
        <div class="card-body d-flex justify-content-between">
            @foreach ($permissionParent->permissionChilds as $permissionChild)
                <div class="form-check form-check-inline">
                    <input type="checkbox"
                        class="form-check-input role_category_check_item" {{ $permissionOfRoles->contains('id', $permissionChild->id) ? 'checked' : ''}}
                        name="permissions[]" id="{{ $permissionChild->title }}" value="{{ $permissionChild->id }}">
                    <label class="form-check-label" for="{{ $permissionChild->title }}">
                        {{ $permissionChild->name }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
@endforeach

