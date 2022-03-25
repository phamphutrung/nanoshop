<div class="modal fade" id="edit_category_modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="form_edit" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-header bg-cyan-200 text-light">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="name">Tên danh mục</label>
                        <input type="text" class="form-control name_edit" id="name_edit" name="name"
                            placeholder="Nhập tên danh mục" onchange="insertSlugEdit()">
                        <small class="form-text text-danger error_edit_name"></small>
                    </div>

                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input readonly type="text" class="form-control slug_edit" id="slug_edit" name="slug">
                        <small class="form-text text-danger error_edit_slug"></small>

                    </div>
                    <div class="form-group">
                        <label>Danh mục cha</label>
                        <select class="form-select category_edit" name="parent_id">


                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Ảnh đại diện</label>
                        <input type="file" accept="image/*" class="form-control" name="avt" value=""
                            onchange="loadFileEdit(event)">
                        <img class="m-3" style="width: 6rem; border-radius: 10px; box-shadow: 0 0 8px rgba(0,0,0,0.2);"
                            id="output_edit">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btn_update" class="btn btn-success"><i
                            class="fas fa-spinner fa-spin d-none mr-2 pl-0"></i>Cập nhật</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
