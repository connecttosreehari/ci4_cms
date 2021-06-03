
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
                <div class="col-sm-6">
                    <div class="float-right">
                        <a href="<?= base_url(route_to('content_groups_add')) ?>" class="btn btn-success"><i class="fa fa-plus"></i> Add</a>
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
                                <th class="text-center">Title</th>
                                <th class="text-center">Slug</th>
                                <th class="text-center">Group Order</th>
                                <th class="text-center" width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($content_groups) : $i = 0; ?>
                                <?php foreach ($content_groups as $content_group) : $i++; ?>
                                    <tr>
                                        <td class="text-center"><?= $i ?></td>
                                        <td class="text-center"><?= $content_group->title ?></td>
                                        <td class="text-center"><?= $content_group->slug ?></td>
                                        <td class="text-center"><input type="text" name="group_order_<?= $content_group->id ?>" class="form-control text-center <?= $validation->hasError('group_order_' . $content_group->id) ? 'is-invalid' : '' ?>" style="width:100px;margin:0 auto;" value="<?= $content_group->group_order ?>" title="Group Order"></td>
                                        <td class="text-center">
                                            <a href="<?= base_url(route_to('content_groups_edit', $content_group->id)) ?>" class="btn btn-dark" title="Edit"><i class="fa fa-edit"></i></a>
                                            <a href="#" class="btn btn-danger confirm-button" title="Delete" data-msg="Are you sure want to delete this record?" data-href="<?= base_url(route_to('content_groups_disable', $content_group->id)) ?>" data-toggle="modal" data-target="#modal-confirm"><i class="fa fa-trash"></i></a>
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