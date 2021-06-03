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
                    <div class="form-group">
                        <label class="col-form-label" for="title">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= $validation->hasError('title') ? 'is-invalid' : '' ?>" id="title" name="title" placeholder="Title">
                        <?= $validation->showError('title', 'error') ?>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="field_type">Type <span class="text-danger">*</span></label>
                        <select class="form-control select2 <?= $validation->hasError('field_type') ? 'is-invalid' : '' ?>" id="field_type" name="field_type" placeholder="Type">
                            <option value="">Select</option>
                            <?php if ($field_types) : ?>
                                <?php foreach ($field_types as $field_type) : ?>
                                    <option value="<?= $field_type->id ?>" <?= set_select('field_type', $field_type->id) ?>><?= $field_type->title ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <?= $validation->showError('field_type', 'error') ?>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="identity">Identity</label>
                        <input type="text" class="form-control <?= $validation->hasError('identity') ? 'is-invalid' : '' ?>" id="identity" name="identity" placeholder="Identity">
                        <?= $validation->showError('identity', 'error') ?>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="field_name">Field Name</label>
                        <input type="text" class="form-control <?= $validation->hasError('field_name') ? 'is-invalid' : '' ?>" id="field_name" name="field_name" placeholder="Field Name">
                        <?= $validation->showError('field_name', 'error') ?>
                    </div>
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-info"></i> Info!</h5>
                        Database field not needed if type is file.
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="database_field">Database Field</label>
                        <input type="text" class="form-control <?= $validation->hasError('database_field') ? 'is-invalid' : '' ?>" id="database_field" name="database_field" placeholder="Database Field">
                        <?= $validation->showError('database_field', 'error') ?>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="form_page">Page <span class="text-danger">*</span></label>
                        <select class="form-control select2 <?= $validation->hasError('form_page') ? 'is-invalid' : '' ?>" id="form_page" name="form_page" placeholder="Page">
                            <option value="">Select</option>
                            <?php if ($form_pages) : ?>
                                <?php foreach ($form_pages as $form_page) : ?>
                                    <option value="<?= $form_page->id ?>" <?= set_select('form_page', $form_page->id) ?>><?= $form_page->title ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <?= $validation->showError('form_page', 'error') ?>
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