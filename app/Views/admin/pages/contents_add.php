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
                    <?php if ($languages && count($languages) > 1) : ?>
                        <div class="dropdown show float-right">
                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= $content_language->title ?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="min-width:4em;">
                                <?php foreach ($languages as $language) : ?>
                                    <a class="dropdown-item <?= $language->code == $content_language->code ? 'active' : '' ?>" href="<?= base_url(route_to('contents_add', $content_group->id, $language->code, $content_form_group->id)) ?>"><?= $language->code ?></a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
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
                <form method="post" accept-charset="utf-8" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <?php if ($content_group->enable_custom_form_group == 1) : ?>
                        <label class="col-form-label" for="custom_form_group">Custom Form Group</label><br />
                        <div class="dropdown show">
                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="custom_form_group" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= $custom_form_group_id > 0 ? $content_form_group->title : 'None' ?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="custom_form_group" style="min-width:4em;">
                                <?php foreach ($form_groups as $form_group) : ?>
                                    <a class="dropdown-item <?= $custom_form_group_id > 0 && $form_group->id == $content_form_group->id ? 'active' : '' ?>" href="<?= base_url(route_to('contents_add_custom_form', $content_group->id, $content_language->code, $form_group->id)) ?>"><?= $form_group->title ?></a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($content_fields['title']['settings']) && $content_fields['title']['settings']->active == 1) : ?>
                        <div class="form-group">
                            <label class="col-form-label" for="title">Title <?= $content_fields['title']['settings']->check_required == 1 ? '<span class="text-danger">*</span>' : '' ?></label>
                            <input type="text" class="form-control <?= $content_language->direction == 'rtl' ? 'direction-rtl' : 'direction-ltr' ?> <?= $validation->hasError('title') ? 'is-invalid' : '' ?>" id="title" name="title" placeholder="Title" value="<?= set_value('title') ?>" onkeyup="slugify_text(this,'slug')">
                            <?= $validation->showError('title', 'error') ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($content_fields['slug']['settings']) && $content_fields['slug']['settings']->active == 1) : ?>
                        <div class="form-group">
                            <label class="col-form-label" for="slug">Slug <?= $content_fields['slug']['settings']->check_required == 1 ? '<span class="text-danger">*</span>' : '' ?></label>
                            <input type="text" class="form-control  <?= $content_language->direction == 'rtl' ? 'direction-rtl' : 'direction-ltr' ?>  <?= $validation->hasError('slug') ? 'is-invalid' : '' ?>" id="slug" name="slug" placeholder="Slug" value="<?= set_value('slug') ?>">
                            <?= $validation->showError('slug', 'error') ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($content_fields['subtitle']['settings']) && $content_fields['subtitle']['settings']->active == 1) : ?>
                        <div class="form-group">
                            <label class="col-form-label" for="subtitle">Subtitle <?= $content_fields['subtitle']['settings']->check_required == 1 ? '<span class="text-danger">*</span>' : '' ?></label>
                            <input type="text" class="form-control <?= $content_language->direction == 'rtl' ? 'direction-rtl' : 'direction-ltr' ?>  <?= $validation->hasError('subtitle') ? 'is-invalid' : '' ?>" id="subtitle" name="subtitle" placeholder="Subtitle" value="<?= set_value('subtitle') ?>">
                            <?= $validation->showError('subtitle', 'error') ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($content_fields['full_name']['settings']) && $content_fields['full_name']['settings']->active == 1) : ?>
                        <div class="form-group">
                            <label class="col-form-label" for="full_name">Full Name <?= $content_fields['full_name']['settings']->check_required == 1 ? '<span class="text-danger">*</span>' : '' ?></label>
                            <input type="text" class="form-control <?= $content_language->direction == 'rtl' ? 'direction-rtl' : 'direction-ltr' ?> <?= $validation->hasError('full_name') ? 'is-invalid' : '' ?>" id="full_name" name="full_name" placeholder="Full Name" value="<?= set_value('full_name') ?>">
                            <?= $validation->showError('full_name', 'error') ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($content_fields['address']['settings']) && $content_fields['address']['settings']->active == 1) : ?>
                        <div class="form-group">
                            <label class="col-form-label" for="address">Address <?= $content_fields['address']['settings']->check_required == 1 ? '<span class="text-danger">*</span>' : '' ?></label>
                            <textarea class="form-control   <?= $content_language->direction == 'rtl' ? 'direction-rtl' : 'direction-ltr' ?> <?= $validation->hasError('address') ? 'is-invalid' : '' ?>" id="address" name="address" placeholder="Address"><?= set_value('address') ?></textarea>
                            <?= $validation->showError('address', 'error') ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($content_fields['email']['settings']) && $content_fields['email']['settings']->active == 1) : ?>
                        <div class="form-group">
                            <label class="col-form-label" for="email">Email <?= $content_fields['email']['settings']->check_required == 1 ? '<span class="text-danger">*</span>' : '' ?></label>
                            <input type="text" class="form-control <?= $validation->hasError('email') ? 'is-invalid' : '' ?>" id="email" name="email" placeholder="Email" value="<?= set_value('email') ?>">
                            <?= $validation->showError('email', 'error') ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($content_fields['phone']['settings']) && $content_fields['phone']['settings']->active == 1) : ?>
                        <div class="form-group">
                            <label class="col-form-label" for="phone">Phone <?= $content_fields['phone']['settings']->check_required == 1 ? '<span class="text-danger">*</span>' : '' ?></label>
                            <input type="text" class="form-control <?= $validation->hasError('phone') ? 'is-invalid' : '' ?>" id="phone" name="phone" placeholder="Phone" value="<?= set_value('phone') ?>">
                            <?= $validation->showError('phone', 'error') ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($content_fields['fax']['settings']) && $content_fields['fax']['settings']->active == 1) : ?>
                        <div class="form-group">
                            <label class="col-form-label" for="fax">Fax <?= $content_fields['fax']['settings']->check_required == 1 ? '<span class="text-danger">*</span>' : '' ?></label>
                            <input type="text" class="form-control <?= $validation->hasError('fax') ? 'is-invalid' : '' ?>" id="fax" name="fax" placeholder="Fax" value="<?= set_value('fax') ?>">
                            <?= $validation->showError('fax', 'error') ?>
                        </div>
                    <?php endif; ?>                    
                    <?php if (!empty($content_fields['short_description']['settings']) && $content_fields['short_description']['settings']->active == 1) : ?>
                        <div class="form-group">
                            <label class="col-form-label" for="short_description">Short Description <?= $content_fields['short_description']['settings']->check_required == 1 ? '<span class="text-danger">*</span>' : '' ?></label>
                            <textarea class="form-control  <?= $content_fields['short_description']['settings']->enable_editor == 1 ? 'summernote' : '' ?> <?= $content_language->direction == 'rtl' ? 'direction-rtl' : 'direction-ltr' ?> <?= $validation->hasError('short_description') ? 'is-invalid' : '' ?>" id="short_description" name="short_description" placeholder="Short Description"><?= set_value('short_description') ?></textarea>
                            <?= $validation->showError('short_description', 'error') ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($content_fields['description']['settings']) && $content_fields['description']['settings']->active == 1) : ?>
                        <div class="form-group">
                            <label class="col-form-label" for="description">Description <?= $content_fields['description']['settings']->check_required == 1 ? '<span class="text-danger">*</span>' : '' ?></label>
                            <textarea class="form-control  <?= $content_fields['description']['settings']->enable_editor == 1 ? 'summernote' : '' ?>  <?= $content_language->direction == 'rtl' ? 'direction-rtl' : 'direction-ltr' ?>  <?= $validation->hasError('description') ? 'is-invalid' : '' ?>" id="description" name="description" placeholder="Description"><?= set_value('description') ?></textarea>
                            <?= $validation->showError('description', 'error') ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($content_fields['image_upload']['settings']) && $content_fields['image_upload']['settings']->active == 1) : ?>
                        <div class="form-group">
                            <label class="col-form-label" for="image_upload">Image Upload <?= $content_fields['image_upload']['settings']->check_required == 1 ? '<span class="text-danger">*</span>' : '' ?></label>
                            <br />
                            <input type="hidden" name="allow_multiple_images" value="<?= $content_fields['image_upload']['settings']->enable_multiple ?>">
                            <input type="file" id="image_upload" name="image_upload[]" <?= $content_fields['image_upload']['settings']->enable_multiple == 1 ? 'multiple' : '' ?>>
                            <?= $validation->showError('image_upload[]', 'error') ?>
                        </div>
                        <div class="row">
                            <?php
                            if (!empty($content_file_details[1])) :
                                foreach ($content_file_details[1] as $file_detail) : ?>
                                    <div class="col-2">
                                        <div class="card bg-light d-flex flex-fill">
                                            <div class="card-body pt-20">
                                                <div class="row">
                                                    <div class="col-12 text-center">
                                                        <a href="<?= base_url('uploads/' . $file_detail->file) ?>" target="_blank"><img src="<?= base_url('uploads/thumb_' . $file_detail->file) ?>" class="img-fluid"></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <div class="text-center">
                                                    <?php if ($content_fields['image_upload']['settings']->file_form_group > 0) : ?>
                                                        <a href="<?= base_url(route_to('contents_file_edit', $file_detail->id, $file_detail->content_id, $content_fields['image_upload']['settings']->file_form_group, $file_detail->language)) ?>" class="btn btn-sm bg-teal" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                    <a href="#" class="btn btn-sm btn-danger confirm-button" title="Delete" data-msg="Are you sure want to delete this image?" data-href="<?= base_url(route_to('contents_file_delete', $file_detail->id, $file_detail->content_id, $file_detail->language)) ?>" data-toggle="modal" data-target="#modal-confirm"><i class="fa fa-trash"></i></a>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                endforeach;
                            endif;
                            ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($content_fields['document_upload']['settings']) && $content_fields['document_upload']['settings']->active == 1) : ?>
                        <div class="form-group">
                            <input type="hidden" name="allow_multiple_documents" value="<?= $content_fields['document_upload']['settings']->enable_multiple ?>">
                            <label class="col-form-label" for="document_upload">Document Upload <?= $content_fields['document_upload']['settings']->check_required == 1 ? '<span class="text-danger">*</span>' : '' ?></label>
                            <br />
                            <input type="file" id="document_upload" name="document_upload[]" <?= $content_fields['document_upload']['settings']->enable_multiple == 1 ? 'multiple' : '' ?>>
                            <?= $validation->showError('document_upload[]', 'error') ?>
                        </div>
                        <div class="row">
                            <?php
                            if (!empty($content_file_details[2])) : $i = 0;
                                foreach ($content_file_details[2] as $file_detail) : $i++;
                                    $data = [];
                                    $data['file_detail'] = $file_detail;
                            ?>
                                    <div class="col-3">
                                        <div class="card d-flex flex-fill">
                                            <div class="card-body pt-2 pb-2">
                                                <a href="<?= base_url('uploads/' . $file_detail->file) ?>" target="_blank">Document <?= $i ?></a>
                                                <a href="#" class="btn btn-sm btn-danger float-right confirm-button" title="Delete" data-msg="Are you sure want to delete this image?" data-href="<?= base_url(route_to('contents_file_delete', $file_detail->id, $file_detail->content_id, $file_detail->language)) ?>" data-toggle="modal" data-target="#modal-confirm"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                endforeach;
                            endif;
                            ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($content_fields['link']['settings']) && $content_fields['link']['settings']->active == 1) : ?>
                        <div class="form-group">
                            <label class="col-form-label" for="link">Link <?= $content_fields['link']['settings']->check_required == 1 ? '<span class="text-danger">*</span>' : '' ?></label>
                            <input type="text" class="form-control <?= $validation->hasError('link') ? 'is-invalid' : '' ?>" id="link" name="link" placeholder="Link" value="<?= set_value('link') ?>">
                            <?= $validation->showError('link', 'error') ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($content_fields['button_name']['settings']) && $content_fields['button_name']['settings']->active == 1) : ?>
                        <div class="form-group">
                            <label class="col-form-label" for="button_name">Button Name <?= $content_fields['button_name']['settings']->check_required == 1 ? '<span class="text-danger">*</span>' : '' ?></label>
                            <input type="text" class="form-control  <?= $content_language->direction == 'rtl' ? 'direction-rtl' : 'direction-ltr' ?>  <?= $validation->hasError('button_name') ? 'is-invalid' : '' ?>" id="button_name" name="button_name" placeholder="Button Name" value="<?= set_value('button_name') ?>">
                            <?= $validation->showError('button_name', 'error') ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($content_fields['icon']['settings']) && $content_fields['icon']['settings']->active == 1) : ?>
                        <div class="form-group">
                            <label class="col-form-label" for="icon">Icon <?= $content_fields['icon']['settings']->check_required == 1 ? '<span class="text-danger">*</span>' : '' ?></label>
                            <input type="text" class="form-control <?= $validation->hasError('icon') ? 'is-invalid' : '' ?>" id="icon" name="icon" placeholder="Icon" value="<?= set_value('icon') ?>">
                            <?= $validation->showError('icon', 'error') ?>
                        </div>
                    <?php endif; ?>                    
                    <?php if ((!empty($content_fields['meta_title']['settings']) && $content_fields['meta_title']['settings']->active == 1)
                        || (!empty($content_fields['meta_keyword']['settings']) && $content_fields['meta_keyword']['settings']->active == 1)
                        || (!empty($content_fields['meta_description']['settings']) && $content_fields['meta_description']['settings']->active == 1)
                        || (!empty($content_fields['meta_canonical_url']['settings']) && $content_fields['meta_canonical_url']['settings']->active == 1)
                    ) : ?>
                        <hr />
                        <h3>SEO</h3>
                        <?php if (!empty($content_fields['meta_title']['settings']) && $content_fields['meta_title']['settings']->active == 1) : ?>
                            <div class="form-group">
                                <label class="col-form-label" for="meta_title">Title <?= $content_fields['meta_title']['settings']->check_required == 1 ? '<span class="text-danger">*</span>' : '' ?></label>
                                <input type="text" class="form-control <?= $validation->hasError('meta_title') ? 'is-invalid' : '' ?>" id="meta_title" name="meta_title" placeholder="Title" value="<?= set_value('meta_title') ?>">
                                <?= $validation->showError('meta_title', 'error') ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($content_fields['meta_keyword']['settings']) && $content_fields['meta_keyword']['settings']->active == 1) : ?>
                            <div class="form-group">
                                <label class="col-form-label" for="meta_keyword">Meta Keyword <?= $content_fields['meta_keyword']['settings']->check_required == 1 ? '<span class="text-danger">*</span>' : '' ?></label>
                                <textarea class="form-control <?= $validation->hasError('meta_keyword') ? 'is-invalid' : '' ?>" id="meta_keyword" name="meta_keyword" placeholder="Meta Keyword"><?= set_value('meta_keyword') ?></textarea>
                                <?= $validation->showError('meta_keyword', 'error') ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($content_fields['meta_description']['settings']) && $content_fields['meta_description']['settings']->active == 1) : ?>
                            <div class="form-group">
                                <label class="col-form-label" for="meta_description">Meta Description <?= $content_fields['meta_description']['settings']->check_required == 1 ? '<span class="text-danger">*</span>' : '' ?></label>
                                <textarea class="form-control   <?= $content_language->direction == 'rtl' ? 'direction-rtl' : 'direction-ltr' ?>  <?= $validation->hasError('meta_description') ? 'is-invalid' : '' ?>" id="meta_description" name="meta_description" placeholder="Meta Description"><?= set_value('meta_description') ?></textarea>
                                <?= $validation->showError('meta_description', 'error') ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($content_fields['meta_canonical_url']['settings']) && $content_fields['meta_canonical_url']['settings']->active == 1) : ?>
                            <div class="form-group">
                                <label class="col-form-label" for="meta_canonical_url">Canonical URL <?= $content_fields['meta_canonical_url']['settings']->check_required == 1 ? '<span class="text-danger">*</span>' : '' ?></label>
                                <textarea class="form-control <?= $validation->hasError('meta_canonical_url') ? 'is-invalid' : '' ?>" id="meta_canonical_url" name="meta_canonical_url" placeholder="Canonical URL"><?= set_value('meta_canonical_url') ?></textarea>
                                <?= $validation->showError('meta_canonical_url', 'error') ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
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