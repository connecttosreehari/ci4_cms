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
                        <a href="<?= base_url(route_to('contents_edit', $content->id, $file_detail->language)) ?>" class="btn btn-dark"><i class="fa fa-arrow-left"></i>
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
                <form method="post" accept-charset="utf-8" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <?php if (!empty($content_fields['file_title']['settings']) && $content_fields['file_title']['settings']->active == 1) : ?>
                        <div class="form-group">
                            <label class="col-form-label" for="file_title">Title <?= $content_fields['file_title']['settings']->check_required == 1 ? '<span class="text-danger">*</span>' : '' ?></label>
                            <input type="text" class="form-control   <?= $content_language->direction == 'rtl' ? 'direction-rtl' : 'direction-ltr' ?>   <?= $validation->hasError('file_title') ? 'is-invalid' : '' ?>" id="file_title" name="file_title" placeholder="Title" value="<?= set_value('file_title', !empty($file_detail->title) ? $file_detail->title : '') ?>">
                            <?= $validation->showError('file_title', 'error') ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($content_fields['file_subtitle']['settings']) && $content_fields['file_subtitle']['settings']->active == 1) : ?>
                        <div class="form-group">
                            <label class="col-form-label" for="file_subtitle">Subtitle <?= $content_fields['file_subtitle']['settings']->check_required == 1 ? '<span class="text-danger">*</span>' : '' ?></label>
                            <input type="text" class="form-control   <?= $content_language->direction == 'rtl' ? 'direction-rtl' : 'direction-ltr' ?>   <?= $validation->hasError('file_subtitle') ? 'is-invalid' : '' ?>" id="file_subtitle" name="file_subtitle" placeholder="Subtitle" value="<?= set_value('file_subtitle', !empty($file_detail->subtitle) ? $file_detail->subtitle : '') ?>">
                            <?= $validation->showError('file_subtitle', 'error') ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($content_fields['file_short_description']['settings']) && $content_fields['file_short_description']['settings']->active == 1) : ?>
                        <div class="form-group">
                            <label class="col-form-label" for="file_short_description">Short Description <?= $content_fields['file_short_description']['settings']->check_required == 1 ? '<span class="text-danger">*</span>' : '' ?></label>
                            <textarea class="form-control  <?= $content_fields['file_short_description']['settings']->enable_editor == 1 ? 'summernote' : '' ?>   <?= $content_language->direction == 'rtl' ? 'direction-rtl' : 'direction-ltr' ?>  <?= $validation->hasError('file_short_description') ? 'is-invalid' : '' ?>" id="file_short_description" name="file_short_description" placeholder="Short Description"><?= set_value('file_short_description', !empty($file_detail->short_description) ? $file_detail->short_description : '') ?></textarea>
                            <?= $validation->showError('file_short_description', 'error') ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($content_fields['file_description']['settings']) && $content_fields['file_description']['settings']->active == 1) : ?>
                        <div class="form-group">
                            <label class="col-form-label" for="file_description">Description <?= $content_fields['file_description']['settings']->check_required == 1 ? '<span class="text-danger">*</span>' : '' ?></label>
                            <textarea class="form-control   <?= $content_fields['file_description']['settings']->enable_editor == 1 ? 'summernote' : '' ?>  <?= $content_language->direction == 'rtl' ? 'direction-rtl' : 'direction-ltr' ?>  <?= $validation->hasError('file_description') ? 'is-invalid' : '' ?>" id="file_description" name="file_description" placeholder="Description"><?= set_value('file_description', !empty($file_detail->description) ? $file_detail->description : '') ?></textarea>
                            <?= $validation->showError('file_description', 'error') ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($content_fields['file_link']['settings']) && $content_fields['file_link']['settings']->active == 1) : ?>
                        <div class="form-group">
                            <label class="col-form-label" for="file_link">Link <?= $content_fields['file_link']['settings']->check_required == 1 ? '<span class="text-danger">*</span>' : '' ?></label>
                            <input type="text" class="form-control <?= $validation->hasError('file_link') ? 'is-invalid' : '' ?>" id="file_link" name="file_link" placeholder="Link" value="<?= set_value('file_link', !empty($file_detail->link) ? $file_detail->link : '') ?>">
                            <?= $validation->showError('file_link', 'error') ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($content_fields['file_button_name']['settings']) && $content_fields['file_button_name']['settings']->active == 1) : ?>
                        <div class="form-group">
                            <label class="col-form-label" for="file_button_name">Button Name <?= $content_fields['file_button_name']['settings']->check_required == 1 ? '<span class="text-danger">*</span>' : '' ?></label>
                            <input type="text" class="form-control   <?= $content_language->direction == 'rtl' ? 'direction-rtl' : 'direction-ltr' ?>  <?= $validation->hasError('file_button_name') ? 'is-invalid' : '' ?>" id="file_button_name" name="file_button_name" placeholder="Button Name" value="<?= set_value('file_button_name', !empty($file_detail->button_name) ? $file_detail->button_name : '') ?>">
                            <?= $validation->showError('file_button_name', 'error') ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($content_fields['file_icon']['settings']) && $content_fields['file_icon']['settings']->active == 1) : ?>
                        <div class="form-group">
                            <label class="col-form-label" for="file_icon">Icon <?= $content_fields['file_icon']['settings']->check_required == 1 ? '<span class="text-danger">*</span>' : '' ?></label>
                            <input type="text" class="form-control <?= $validation->hasError('file_icon') ? 'is-invalid' : '' ?>" id="file_icon" name="file_icon" placeholder="Icon" value="<?= set_value('file_icon', !empty($file_detail->file_icon) ? $file_detail->file_icon : '') ?>">
                            <?= $validation->showError('file_icon', 'error') ?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label class="col-form-label" for="file_upload">Upload <?= $content_file_settings->check_required == 1 ? '<span class="text-danger">*</span>' : '' ?></label>
                        <br />
                        <input type="file" id="file_upload" name="file_upload">
                        <br />
                        <?= $validation->showError('file_upload', 'error') ?>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <div class="card bg-light d-flex flex-fill">
                                <div class="card-body pt-20">
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <img src="<?= base_url('uploads/' . $file_detail->file) ?>" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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