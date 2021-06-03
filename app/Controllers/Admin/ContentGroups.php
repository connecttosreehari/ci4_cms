<?php

namespace App\Controllers\Admin;

use App\Controllers\AdminController;
//loading model
use App\Models\ContentGroupsModel;
use App\Models\FormGroupsModel;

class ContentGroups extends AdminController
{
    /**
     * @var $content_groups_model
     */
    protected $content_groups_model;
    /**
     * @var $form_groups_model
     */
    protected $form_groups_model;


    /**
     * Constructor
     * @return void
     */
    public function __construct()
    {
        // assigning models
        $this->content_groups_model = new ContentGroupsModel();
        $this->form_groups_model = new FormGroupsModel();
        // getting form groups
        $form_groups = $this->form_groups_model->where(['active' => 1, 'form_page' => 1])->orderBy('title', 'ASC')->findAll();
        $this->data['form_groups'] = $form_groups;
    }
    /**
     * Listing all records
     * @return void
     */
    public function index()
    {
        // display title
        $this->data['content_title'] = 'Content Groups';
        $this->data['content_subtitle'] = 'List';
        // active menu item flag
        $this->data['active_menu'] = 'content_groups';
        // getting records
        $content_groups = $this->content_groups_model->where('active', 1)->orderBy('group_order', 'ASC')->orderBy('title', 'ASC')->findAll();
        $this->data['content_groups'] = $content_groups;
        if ($content_groups) {
            $validation_rules = [];
            foreach ($content_groups as $content_group) {
                // validation rules
                $validation_rules['group_order_' . $content_group->id] = [
                    'label' => 'group order',
                    'rules' => 'trim|permit_empty|is_natural_no_zero',
                ];
            }
            $this->validation->setRules($validation_rules);
        }
        // validating post request
        if ($this->request->getPost()) {
            if ($content_groups) {
                if ($this->validation->withRequest($this->request)->run()) {
                    foreach ($content_groups as $content_group) {
                        $group_order = $this->request->getPost('group_order_' . $content_group->id);
                        $input_data = [];
                        $input_data['group_order'] = $group_order;
                        $this->content_translations_model->update($content_group->id, $input_data);
                    }
                    $this->generate_message('toastr_success', 'updated', 'order');
                    return redirect()->to(current_url());
                } else {
                    $this->generate_message('toastr_error', 'invalid', 'order');
                }
            }
        }
        // rendering view
        $this->render_page('pages/content_groups');
    }
    /**
     * Add record
     * @return void|redirect
     */
    public function add()
    {
        // display title
        $this->data['content_title'] = 'Content Groups';
        $this->data['content_subtitle'] = 'Add';
        // active menu item flag
        $this->data['active_menu'] = 'content_groups';

        // getting records
        $groups = $this->content_groups_model->where('active', 1)->orderBy('title', 'ASC')->findAll();
        $this->data['groups'] = $groups;
        // validation rules
        $this->validation->setRules([
            'title' => [
                'label' => 'title',
                'rules' => 'trim|required|max_length[50]',
            ],
            'slug' => [
                'label' => 'slug',
                'rules' => 'trim|required|alpha_dash|max_length[100]|is_unique[content_groups.slug]',
            ],
            'form_group' => [
                'label' => 'form group',
                'rules' => 'trim|required|is_natural_no_zero',
            ],
            'enable_add' => [
                'label' => 'enable add',
                'rules' => 'trim|permit_empty|is_natural_no_zero',
            ],
            'enable_edit' => [
                'label' => 'enable edit',
                'rules' => 'trim|permit_empty|is_natural_no_zero',
            ],
            'enable_delete' => [
                'label' => 'enable delete',
                'rules' => 'trim|permit_empty|is_natural_no_zero',
            ],
            'enable_order' => [
                'label' => 'enable order',
                'rules' => 'trim|permit_empty|is_natural_no_zero',
            ],
            'enable_custom_form_group' => [
                'label' => 'enable custom form group',
                'rules' => 'trim|permit_empty|is_natural_no_zero',
            ],
            'hide_group' => [
                'label' => 'hide group',
                'rules' => 'trim|permit_empty|is_natural_no_zero',
            ],
            'menu_icon' => [
                'label' => 'menu icon',
                'rules' => 'trim|max_length[20]',
            ],
            'related_groups[]' => [
                'label' => 'related groups',
                'rules' => 'trim|permit_empty|is_natural_no_zero',
            ],
        ]);
        // validating post request
        if ($this->request->getPost() && $this->validation->withRequest($this->request)->run()) {
            $input_data = [];
            $input_data['title'] = $this->request->getPost('title');
            $input_data['slug'] = $this->request->getPost('slug');
            $input_data['form_group'] = $this->request->getPost('form_group');
            $input_data['enable_add'] = $this->request->getPost('enable_add');
            $input_data['enable_edit'] = $this->request->getPost('enable_edit');
            $input_data['enable_delete'] = $this->request->getPost('enable_delete');
            $input_data['enable_order'] = $this->request->getPost('enable_order');
            $input_data['hide_group'] = $this->request->getPost('hide_group');
            $input_data['menu_icon'] = $this->request->getPost('menu_icon');
            $input_data['enable_custom_form_group'] = $this->request->getPost('enable_custom_form_group');
            $related_groups = $this->request->getPost('related_groups[]');
            $related_groups = implode(',', (array)$related_groups);
            $input_data['related_groups'] = $related_groups;
            $input_data['created_by'] = $_SESSION['user_id'];
            $input_data['active'] = '1';
            $this->content_groups_model->insert($input_data);
            $this->generate_message('toastr_success', 'created', 'content group');
            return redirect()->to(current_url());
        }
        // rendering view
        $this->render_page('pages/content_groups_add');
    }

    /**
     * Edit record
     * @param int $id
     * @return void|redirect
     */
    public function edit(int $id)
    {
        // display title
        $this->data['content_title'] = 'Content Groups';
        $this->data['content_subtitle'] = 'Edit';
        // active menu item flag
        $this->data['active_menu'] = 'content_groups';
        // getting records
        $groups = $this->content_groups_model->where('active', 1)->orderBy('title', 'ASC')->findAll();
        $this->data['groups'] = $groups;
        // getting content group
        $content_group = $this->content_groups_model->where(['id' => $id, 'active' => 1])->find();
        if ($content_group) {
            $content_group = $content_group[0];
        } else {
            $this->generate_message('toastr_error', 'invalid', 'content group');
            return  redirect()->back();
        }
        $this->data['content_group'] = $content_group;
        // validation rules
        $this->validation->setRules([
            'title' => [
                'label' => 'title',
                'rules' => 'trim|required|max_length[50]',
            ],
            'slug' => [
                'label' => 'slug',
                'rules' => 'trim|required|alpha_dash|max_length[100]|is_unique[content_groups.slug,id,' . $id . ']',
            ],
            'form_group' => [
                'label' => 'form group',
                'rules' => 'trim|required|is_natural_no_zero',
            ],
            'enable_add' => [
                'label' => 'enable add',
                'rules' => 'trim|permit_empty|is_natural_no_zero',
            ],
            'enable_edit' => [
                'label' => 'enable edit',
                'rules' => 'trim|permit_empty|is_natural_no_zero',
            ],
            'enable_delete' => [
                'label' => 'enable delete',
                'rules' => 'trim|permit_empty|is_natural_no_zero',
            ],
            'enable_custom_form_group' => [
                'label' => 'enable custom form group',
                'rules' => 'trim|permit_empty|is_natural_no_zero',
            ],
            'hide_group' => [
                'label' => 'hide group',
                'rules' => 'trim|permit_empty|is_natural_no_zero',
            ],
            'menu_icon' => [
                'label' => 'menu icon',
                'rules' => 'trim|max_length[20]',
            ],
            'related_groups[]' => [
                'label' => 'related groups',
                'rules' => 'trim|permit_empty|is_natural_no_zero',
            ],
        ]);
        // validating post request
        if ($this->request->getPost() && $this->validation->withRequest($this->request)->run()) {
            $input_data = [];
            $input_data['title'] = $this->request->getPost('title');
            $input_data['slug'] = $this->request->getPost('slug');
            $input_data['form_group'] = $this->request->getPost('form_group');
            $input_data['enable_add'] = $this->request->getPost('enable_add');
            $input_data['enable_edit'] = $this->request->getPost('enable_edit');
            $input_data['enable_delete'] = $this->request->getPost('enable_delete');
            $input_data['enable_order'] = $this->request->getPost('enable_order');
            $input_data['hide_group'] = $this->request->getPost('hide_group');
            $input_data['menu_icon'] = $this->request->getPost('menu_icon');
            $input_data['enable_custom_form_group'] = $this->request->getPost('enable_custom_form_group');
            $related_groups = $this->request->getPost('related_groups[]');
            $related_groups = implode(',', (array)$related_groups);
            $input_data['related_groups'] = $related_groups;
            $input_data['updated_by'] =  $_SESSION['user_id'];
            $input_data['active'] = '1';
            $this->content_groups_model->update($id, $input_data);
            $this->generate_message('toastr_success', 'updated', 'content group');
            return redirect()->to(current_url());
        }
        // rendering view
        $this->render_page('pages/content_groups_edit');
    }

    /**
     * Disable record
     * @param $id
     * @return redirect
     */
    public function disable($id)
    {
        $input_data = [];
        $input_data['active'] = 2;
        $this->content_groups_model->update($id, $input_data);
        $this->generate_message('toastr_success', 'deleted', 'content group');
        return redirect()->back();
    }
}
