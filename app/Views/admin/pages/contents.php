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
                    <?php if ($content_group->enable_add) : ?>
                        <div class="float-right">
                            <a href="<?= base_url(route_to('contents_add', $content_group->id, $site_lang)) ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add</a>
                        </div>
                    <?php endif; ?>
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
                    <table class="table table-bordered table-hover custom-data-table">
                        <thead>
                            <tr>
                                <th class="text-center" width="10%">Sl.No.</th>
                                <th class="text-center">Title</th>
                                <?php if ($content_group->enable_order == 1) : ?>
                                    <th class="text-center" width="10%">Order</th>
                                <?php endif; ?>
                                <?php if ($content_group->enable_edit == 1 || $content_group->enable_delete == 1) : ?>
                                    <th class="text-center" width="15%">Action</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($content_translations) : $i = 0; ?>
                                <?php foreach ($content_translations as $content_translation) : $i++; ?>
                                    <tr>
                                        <td class="text-center"><?= $i ?></td>
                                        <td class="text-center"><?= $content_translation->title ?></td>
                                        <?php if ($content_group->enable_order == 1) : ?>
                                            <td class="text-center"><input type="text" name="content_order_<?= $content_translation->content_id ?>" class="form-control text-center  <?= $validation->hasError('content_order_' . $content_translation->content_id) ? 'is-invalid' : '' ?>" style="width:100px;margin:0 auto;" value="<?= $content_translation->content_order ?>" title="Content Order"></td>
                                        <?php endif; ?>
                                        <?php if ($content_group->enable_edit || $content_group->enable_delete) : ?>
                                            <td class="text-center">
                                                <?php if ($content_group->enable_edit) : ?>
                                                    <a href="<?= base_url(route_to('contents_edit', $content_translation->content_id, $site_lang)) ?>" class="btn btn-dark" title="Edit"><i class="fa fa-edit"></i></a>
                                                <?php endif; ?>
                                                <?php if ($content_group->enable_delete) : ?>
                                                    <a href="#" class="btn btn-danger confirm-button" title="Delete" data-msg="Are you sure want to delete this record?" data-href="<?= base_url(route_to('contents_disable', $content_translation->content_id, $content_group->id)) ?>" data-toggle="modal" data-target="#modal-confirm"><i class="fa fa-trash"></i></a>
                                                <?php endif; ?>
                                            </td>
                                        <?php endif; ?>
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