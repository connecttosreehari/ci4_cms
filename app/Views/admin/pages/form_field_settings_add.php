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
                    <div class="form-group">
                        <label class="col-form-label" for="form_field">Type <span class="text-danger">*</span></label>
                        <select class="form-control select2 <?= $validation->hasError('form_field') ? 'is-invalid' : '' ?>" id="form_field" name="form_field" placeholder="Field">
                            <option value="">Select</option>
                            <?php if ($form_fields) : ?>
                                <?php foreach ($form_fields as $form_field) : ?>
                                    <option value="<?= $form_field->id ?>" <?= set_select('form_field', $form_field->id, !empty($form_field_settings->form_field) && $form_field_settings->form_field == $form_field->id ? true : false) ?>><?= $form_field->title ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <?= $validation->showError('form_field', 'error') ?>
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