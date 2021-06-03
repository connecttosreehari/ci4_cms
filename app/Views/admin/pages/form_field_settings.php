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
                <form method="get" accept-charset="utf-8">
                    <?= csrf_field() ?>
                    <table class="table table-bordered table-hover custom-data-table">
                        <thead>
                            <tr>
                                <th class="text-center" width="10%">Sl.No.</th>
                                <th class="text-center">Field</th>
                                <th class="text-center" width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($form_field_settings) : $i = 0; ?>
                                <?php foreach ($form_field_settings as $form_field_setting) : $i++; ?>
                                    <tr>
                                        <td class="text-center"><?= $i ?></td>
                                        <td class="text-center"><?= $form_field_setting->form_field_title ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url(route_to('form_field_settings_edit', $form_field_setting->form_group, $form_field_setting->form_field)) ?>" class="btn btn-dark" title="Configuration"><i class="fa fa-wrench"></i></a>
                                            <a href="#" class="btn btn-danger confirm-button" title="Delete" data-msg="Are you sure want to delete this record?" data-href="<?= base_url(route_to('form_field_settings_disable', $form_field_setting->form_group, $form_field_setting->id)) ?>" data-toggle="modal" data-target="#modal-confirm"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <div class="form-group mt-2 mb-2">
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