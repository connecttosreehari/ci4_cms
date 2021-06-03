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
        <?= $alert_msg ?>
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
                        <label class="col-form-label" for="old_password">Old Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control <?= $validation->hasError('old_password') ? 'is-invalid' : '' ?>" id="old_password" name="old_password" placeholder="Old Password">
                        <?= $validation->showError('old_password', 'error') ?>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="new_password">New Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control <?= $validation->hasError('new_password') ? 'is-invalid' : '' ?>" id="new_password" name="new_password" placeholder="New Password">
                        <?= $validation->showError('new_password', 'error') ?>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="confirm_password">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control <?= $validation->hasError('confirm_password') ? 'is-invalid' : '' ?>" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
                        <?= $validation->showError('confirm_password', 'error') ?>
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