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
                        <label class="col-form-label" for="title">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= $validation->hasError('title') ? 'is-invalid' : '' ?>" id="title" name="title" placeholder="Title" onkeyup="slugify_text(this,'slug')">
                        <?= $validation->showError('title', 'error') ?>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="slug">Slug <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= $validation->hasError('slug') ? 'is-invalid' : '' ?>" id="slug" name="slug" placeholder="Slug">
                        <?= $validation->showError('slug', 'error') ?>
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