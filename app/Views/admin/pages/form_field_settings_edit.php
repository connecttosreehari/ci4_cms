<?= $this->extend("admin/layouts/master") ?>
<?= $this->section("<<content>>") ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= !empty($content_title) ? $content_title : '' ?></h1>
                </div>
                <div class="col-sm-6">
                    <div class="float-right">
                        <a href="<?= base_url(route_to('form_field_settings_add', $form_group->id)) ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add</a>
                        <a href="<?= base_url(route_to('form_field_settings', $form_group->id)) ?>" class="btn btn-dark"><i class="fa fa-arrow-left"></i>
                            Go Back</a>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card card-primary">
            <?php if (!empty($content_subtitle)) : ?>
                <div class="card-header">
                    <h3 class="card-title"><?= $content_subtitle ?></h3>
                </div>
            <?php endif; ?>
            <div class="card-body">
                <form method="post" accept-charset="utf-8">
                    <?= csrf_field() ?>
                    <div class="row">
                        <?php if ($form_field->field_type != 6) : ?>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="check_required" name="check_required" value="1" <?= set_checkbox('check_required', 1, $form_field_setting->check_required == 1 ? true : false) ?>>
                                        <label for="check_required">Check Required</label>
                                        <?= $validation->showError('check_required', 'error') ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif;  ?>
                        <?php if ($form_field->field_type == 1) : ?>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="check_valid_email" name="check_valid_email" value="1" <?= set_checkbox('check_valid_email', 1, $form_field_setting->check_valid_email == 1 ? true : false) ?>>
                                        <label for="check_valid_email">Check Valid Email</label>
                                        <?= $validation->showError('check_valid_email', 'error') ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if ($form_field->field_type == 2) : ?>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="enable_editor" name="enable_editor" value="1" <?= set_checkbox('enable_editor', 1, $form_field_setting->enable_editor == 1 ? true : false) ?>>
                                        <label for="enable_editor">Enable Editor</label>
                                        <?= $validation->showError('enable_editor', 'error') ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if ($form_field->field_type == 6 || $form_field->field_type == 5) : ?>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="enable_multiple" name="enable_multiple" value="1" <?= set_checkbox('enable_multiple', 1, $form_field_setting->enable_multiple == 1 ? true : false) ?>>
                                        <label for="enable_multiple">Enable Multiple</label>
                                        <?= $validation->showError('enable_multiple', 'error') ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="row">
                        <?php if ($form_field->field_type == 1 || $form_field->field_type == 2) : ?>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="match_regex">Regex</label>
                                    <input type="text" class="form-control <?= $validation->hasError('match_regex') ? 'is-invalid' : '' ?>" id="match_regex" name="match_regex" placeholder="Regex" value="<?= set_value('match_regex', !empty($form_field_setting->match_regex) ? $form_field_setting->match_regex : '') ?>">
                                    <?= $validation->showError('match_regex', 'error') ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if ($form_field->field_type == 1 || $form_field->field_type == 2) : ?>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="max_length">Max Length</label>
                                    <input type="text" class="form-control <?= $validation->hasError('max_length') ? 'is-invalid' : '' ?>" id="max_length" name="max_length" placeholder="Max Length" value="<?= set_value('max_length', !empty($form_field_setting->max_length) ? $form_field_setting->max_length : '') ?>">
                                    <?= $validation->showError('max_length', 'error') ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="col-form-label" for="form_field_status">Form Field Status<span class="text-danger">*</span></label>
                                <select class="form-control select2 <?= $validation->hasError('form_field_status') ? 'is-invalid' : '' ?>" id="form_field_status" name="form_field_status">
                                    <option value="1" <?= set_select('form_field_status', $form_field_setting->active, $form_field_setting->active == 1 ? true : true) ?>>Active</option>
                                    <option value="2" <?= set_select('form_field_status', $form_field_setting->active, $form_field_setting->active == 2 ? true : false) ?>>Inactive</option>
                                </select>
                                <?= $validation->showError('form_field_status', 'error') ?>
                            </div>
                        </div>
                    </div>
                    <?php if ($form_field->field_type == 6) : ?>
                        <hr />
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="enable_file_edit" name="enable_file_edit" value="1" <?= set_checkbox('enable_file_edit', 1, $form_field_setting->enable_file_edit == 1 ? true : false) ?>>
                                        <label for="enable_file_edit">Enable File Edit</label>
                                        <?= $validation->showError('enable_file_edit', 'error') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="enable_resize" name="enable_resize" value="1" <?= set_checkbox('enable_resize', 1, $form_field_setting->enable_resize == 1 ? true : false) ?>>
                                        <label for="enable_resize">Enable Resize</label>
                                        <?= $validation->showError('enable_resize', 'error') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="enable_file_delete" name="enable_file_delete" value="1" <?= set_checkbox('enable_file_delete', 1, $form_field_setting->enable_file_delete == 1 ? true : false) ?>>
                                        <label for="enable_file_delete">Enable File Delete</label>
                                        <?= $validation->showError('enable_file_delete', 'error') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="enable_file_order" name="enable_file_order" value="1" <?= set_checkbox('enable_file_order', 1, $form_field_setting->enable_file_order == 1 ? true : false) ?>>
                                        <label for="enable_file_order">Enable File Order</label>
                                        <?= $validation->showError('enable_file_order', 'error') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="allowed_extensions">Allowed Extensions</label>
                                    <input type="text" class="form-control <?= $validation->hasError('allowed_extensions') ? 'is-invalid' : '' ?>" id="allowed_extensions" name="allowed_extensions" placeholder="Allowed Extensions" value="<?= set_value('allowed_extensions', !empty($form_field_setting->allowed_extensions) ? $form_field_setting->allowed_extensions : '') ?>">
                                    <?= $validation->showError('allowed_extensions', 'error') ?>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="file_form_group">File Form Group <span class="text-danger">*</span></label>
                                    <select class="form-control select2 <?= $validation->hasError('file_form_group') ? 'is-invalid' : '' ?>" id="file_form_group" name="file_form_group" placeholder="File Field Group">
                                        <option value="">Select</option>
                                        <?php if ($file_form_groups) : ?>
                                            <?php foreach ($file_form_groups as $file_form_group) : ?>
                                                <option value="<?= $file_form_group->id ?>" <?= set_select('file_form_group', $file_form_group->id, $form_field_setting->file_form_group == $file_form_group->id ? true : false) ?>><?= $file_form_group->title ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <?= $validation->showError('file_form_group', 'error') ?>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="min_width">Min Width</label>
                                    <input type="text" class="form-control <?= $validation->hasError('min_width') ? 'is-invalid' : '' ?>" id="min_width" name="min_width" placeholder="Min Width" value="<?= set_value('min_width', !empty($form_field_setting->min_width) ? $form_field_setting->min_width : '') ?>">
                                    <?= $validation->showError('min_width', 'error') ?>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="min_height">Min Height</label>
                                    <input type="text" class="form-control <?= $validation->hasError('min_height') ? 'is-invalid' : '' ?>" id="min_height" name="min_height" placeholder="Min Height" value="<?= set_value('min_height', !empty($form_field_setting->min_height) ? $form_field_setting->min_height : '') ?>">
                                    <?= $validation->showError('min_height', 'error') ?>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="max_width">Max Width</label>
                                    <input type="text" class="form-control <?= $validation->hasError('max_width') ? 'is-invalid' : '' ?>" id="max_width" name="max_width" placeholder="Max Width" value="<?= set_value('max_width', !empty($form_field_setting->max_width) ? $form_field_setting->max_width : '') ?>">
                                    <?= $validation->showError('allowed_extensions', 'error') ?>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="max_height">Max Height</label>
                                    <input type="text" class="form-control <?= $validation->hasError('max_height') ? 'is-invalid' : '' ?>" id="max_height" name="max_height" placeholder="Max Height" value="<?= set_value('max_height', !empty($form_field_setting->max_height) ? $form_field_setting->max_height : '') ?>">
                                    <?= $validation->showError('max_height', 'error') ?>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="max_size">Max Size</label>
                                    <input type="text" class="form-control <?= $validation->hasError('max_size') ? 'is-invalid' : '' ?>" id="max_size" name="max_size" placeholder="Max Size" value="<?= set_value('max_size', !empty($form_field_setting->max_size) ? $form_field_setting->max_size : '') ?>">
                                    <?= $validation->showError('max_size', 'error') ?>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="thumb_width">Thumb Width</label>
                                    <input type="text" class="form-control <?= $validation->hasError('thumb_width') ? 'is-invalid' : '' ?>" id="thumb_width" name="thumb_width" placeholder="Max Width" value="<?= set_value('thumb_width', !empty($form_field_setting->thumb_width) ? $form_field_setting->thumb_width : '') ?>">
                                    <?= $validation->showError('allowed_extensions', 'error') ?>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="col-form-label" for="thumb_height">Thumb Height</label>
                                    <input type="text" class="form-control <?= $validation->hasError('thumb_height') ? 'is-invalid' : '' ?>" id="thumb_height" name="thumb_height" placeholder="Max Height" value="<?= set_value('thumb_height', !empty($form_field_setting->thumb_height) ? $form_field_setting->thumb_height : '') ?>">
                                    <?= $validation->showError('thumb_height', 'error') ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary float-right">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?= $this->endSection() ?>