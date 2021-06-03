<?= $this->extend("admin/layouts/master") ?>
<?= $this->section("<<content>>") ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= !empty($content_title)?$content_title:'' ?></h1>
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
                        <label class="col-form-label" for="contact_email">Contact Email <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= $validation->hasError('contact_email') ? 'is-invalid' : '' ?>" id="contact_email" name="contact_email" placeholder="Contact Email" value="<?=$settings->contact_email?>">
                        <?= $validation->showError('contact_email', 'error') ?>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="contact_phone">Call Us</label>
                        <input type="text" class="form-control <?= $validation->hasError('contact_phone') ? 'is-invalid' : '' ?>" id="contact_phone" name="contact_phone" placeholder="Call Us"  value="<?=$settings->contact_phone?>">
                        <?= $validation->showError('contact_phone', 'error') ?>
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