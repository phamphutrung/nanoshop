<div class="modal fade" id="modal_add_product" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header bg-cyan-200 text-light">
                    <h2>Thêm sản phẩm</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form_add" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-5">
                                <div class="col-md-12 mb-4">
                                    <label for="category">Danh mục</label>
                                    <select id="select_category_chosse" class="form-select" name="category_id">
                                        <option value="">Chọn danh mục</option>
                                        {!! $htmlSelectOptionCategory !!}
                                    </select>
                                    <small class="text-danger text_error_category_id"></small>
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label for="name">Tên sản phẩm</label>
                                    <input id="name" class="form-control" type="text" name="name" is-invalid
                                        placeholder="Nhập tên sản phẩm" onchange="insertSlug()">
                                    <small class="text-danger text_error_name"></small>
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label for="slug">Slug</label>
                                    <input id="slug" class="form-control" type="text" name="slug">
                                </div>
                                <small class="text-danger text_error_slug"></small>

                                <div class="col-md-12 mb-4">
                                    <label for="original_price">Giá gốc</label>
                                    <input value="{{ old('original_price') }}" id="original_price" class="form-control"
                                        type="text" name="original_price" placeholder="Nhập giá gốc">
                                    <small class="text-danger text_error_original_price"></small>

                                </div>
                                <div class="col-md-12 mb-4">
                                    <label for="selling_price">Giá bán</label>
                                    <input value="{{ old('selling_price') }}" id="selling_price" class="form-control"
                                        type="text" name="selling_price" placeholder="Nhập giá bán hiện tại">
                                    <small class="text-danger text_error_selling_price"></small>

                                </div>

                                <div class="col-md-12 mb-4">
                                    <label for="formFile" class="form-label">Ảnh đại diện</label>
                                    <input class="form-control" type="file" accept="image/*" id="feature_image_path"
                                        name="feature_image_path" onchange="loadFile(event)">
                                    <div class="mt-3" id="avt" style="min-height: 85px">
                                        <img style="width: 85px; border-radius: 10px; box-shadow: 0 0 8px rgba(0,0,0,0.2);"
                                            id="output">
                                    </div>
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label for="formFile" class="form-label">Ảnh chi tiết</label>
                                    <input class="form-control" type="file" accept="image/*" id="image_path"
                                        name="image_path[]" multiple>
                                    <div id="preview"></div>
                                </div>

                                <div class="col-md-12 d-flex align-items-center">
                                    <div class="col-md-6 mb-4 ml-3">
                                        <input class="form-check-input" type="checkbox" id="status" name="status">
                                        <label class="form-check-label" for="status">
                                            Kích hoạt
                                        </label>
                                    </div>
                                    <div class="col-md-6 mb-4 f-right">
                                        <input class="form-check-input" type="checkbox" id="popular" name="trending">
                                        <label class="form-check-label" for="popular">
                                            Xu hướng
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-4">
                                    <label>Tags</label>
                                    <select name="tags[]" id="tags_select2_choose" multiple>
                                        {!! $htmlSelectOptionTag !!}
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-7">
                                <div class="col-md-12 mb-4">
                                    <label for="description">Mô tả ngắn</label>
                                    <textarea class="form-control editor" name="description" id="description" rows="15"
                                        placeholder="Nhập mô tả ngắn"></textarea>
                                </div>

                                <div class="col-md-12 mb-4">
                                    <label for="description">Nội dung</label>
                                    <textarea class="form-control editor" name="content" id="description" rows="27"
                                        placeholder="Nhập nội dung sản phẩm"></textarea>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btn_add" class="btn btn-success"><i
                            class="fas fa-spinner fa-spin d-none mr-2 pl-0"></i>Tạo
                        mới</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>