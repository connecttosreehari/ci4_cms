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
                        <a href="<?= base_url(route_to('content_groups_add')) ?>" class="btn btn-success"><i class="fa fa-plus"></i>
                            Add</a>
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
                        <label class="col-form-label" for="title">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= $validation->hasError('title') ? 'is-invalid' : '' ?>" id="title" name="title" placeholder="Title" value="<?= set_value('title', !empty($content_group->title) ? $content_group->title : '') ?>" onkeyup="slugify_text(this,'slug')">
                        <?= $validation->showError('title', 'error') ?>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="slug">Slug <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= $validation->hasError('slug') ? 'is-invalid' : '' ?>" id="slug" name="slug" placeholder="Slug" value="<?= set_value('slug', !empty($content_group->slug) ? $content_group->slug : '') ?>">
                        <?= $validation->showError('slug', 'error') ?>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="form_group">Form Group <span class="text-danger">*</span></label>
                        <select class="form-control select2 <?= $validation->hasError('form_group') ? 'is-invalid' : '' ?>" id="form_group" name="form_group">
                            <option value="">Select</option>
                            <?php if ($form_groups) : ?>
                                <?php foreach ($form_groups as $form_group) : ?>
                                    <option value="<?= $form_group->id ?>" <?= set_select('form_group', $form_group->id, $content_group->form_group == $form_group->id ? true : false) ?>><?= $form_group->title ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <?= $validation->showError('form_group', 'error') ?>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="enable_add" name="enable_add" value="1" <?= set_checkbox('enable_add', 1, $content_group->enable_add == 1 ? true : false) ?>>
                                    <label for="enable_add">Enable Add</label><br/>
                                    <?= $validation->showError('enable_add', 'error') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="enable_edit" name="enable_edit" value="1" <?= set_checkbox('enable_edit', 1, $content_group->enable_edit == 1 ? true : false) ?>>
                                    <label for="enable_edit">Enable Edit</label><br/>
                                    <?= $validation->showError('enable_edit', 'error') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="enable_delete" name="enable_delete" value="1" <?= set_checkbox('enable_delete', 1, $content_group->enable_delete == 1 ? true : false) ?>>
                                    <label for="enable_delete">Enable Delete</label><br/>
                                    <?= $validation->showError('enable_delete', 'error') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="enable_order" name="enable_order" value="1" <?= set_checkbox('enable_order', 1, $content_group->enable_order == 1 ? true : false) ?>>
                                    <label for="enable_order">Enable Order</label><br/>
                                    <?= $validation->showError('enable_order', 'error') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="hide_group" name="hide_group" value="1" <?= set_checkbox('hide_group', 1, $content_group->hide_group == 1 ? true : false) ?>>
                                    <label for="hide_group">Hide Group</label><br/>
                                    <?= $validation->showError('hide_group', 'error') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="icheck-primary d-inline">
                                    <input type="checkbox" id="enable_custom_form_group" name="enable_custom_form_group" value="1" <?= set_checkbox('enable_custom_form_group', 1, $content_group->enable_custom_form_group == 1 ? true : false) ?>>
                                    <label for="enable_custom_form_group">Enable Custom Form Group</label><br />
                                    <?= $validation->showError('enable_custom_form_group', 'error') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="menu_icon">Menu Icon <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?= $validation->hasError('menu_icon') ? 'is-invalid' : '' ?>" id="menu_icon" name="menu_icon" placeholder="Menu Icon" value="<?= set_value('title', !empty($content_group->menu_icon) ? $content_group->menu_icon : '') ?>">
                        <?= $validation->showError('menu_icon', 'error') ?>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="related_groups">Related Groups</label>
                        <select class="form-control select2 <?= $validation->hasError('related_groups') ? 'is-invalid' : '' ?>" id="related_groups" name="related_groups[]" multiple>
                            <?php if ($groups) : ?>
                                <?php foreach ($groups as $group) :  if ($group->id == $content_group->id) continue; ?>
                                    <option value="<?= $group->id ?>" <?= set_select('related_groups', $group->id, in_array($group->id, explode(',', $content_group->related_groups))) ?>><?= $group->title ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <?= $validation->showError('related_groups[]', 'error') ?>
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