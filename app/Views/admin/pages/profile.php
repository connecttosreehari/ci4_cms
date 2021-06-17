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
                        <label class="col-form-label" for="first_name">First Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= $validation->hasError('first_name') ? 'is-invalid' : '' ?>" id="first_name" name="first_name" placeholder="First Name" value="<?=$user->first_name?>">
                        <?= $validation->showError('first_name', 'error') ?>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="last_name">Last Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= $validation->hasError('last_name') ? 'is-invalid' : '' ?>" id="last_name" name="last_name" placeholder="Last Name"  value="<?=$user->last_name?>">
                        <?= $validation->showError('last_name', 'error') ?>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="username">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= $validation->hasError('username') ? 'is-invalid' : '' ?>" id="username" name="username" placeholder="Username"  value="<?=$user->username?>">
                        <?= $validation->showError('username', 'error') ?>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="email">Email <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= $validation->hasError('email') ? 'is-invalid' : '' ?>" id="email" name="email" placeholder="Email"  value="<?=$user->email?>">
                        <?= $validation->showError('email', 'error') ?>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="company">Company</label>
                        <input type="text" class="form-control <?= $validation->hasError('company') ? 'is-invalid' : '' ?>" id="company" name="company" placeholder="Company"  value="<?=$user->company?>">
                        <?= $validation->showError('company', 'error') ?>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="phone">Phone</label>
                        <input type="text" class="form-control <?= $validation->hasError('phone') ? 'is-invalid' : '' ?>" id="phone" name="phone" placeholder="Phone"  value="<?=$user->phone?>">
                        <?= $validation->showError('phone', 'error') ?>
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