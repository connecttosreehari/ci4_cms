<?php

namespace App\Controllers\Admin;

use App\Controllers\AdminController;
// loading models
use App\Models\FormGroupsModel;
use App\Models\FormPagesModel;
use App\Models\FormFieldSettingsModel;

class FormGroups extends AdminController
{
    /**
     * @var $form_groups_model
     */
    protected $form_groups_model;
    /**
     * @var $form_pages_model
     */
    protected $form_pages_model;
    /**
     * @var $form_pages_model
     */
    protected $form_field_settings_model;
    /**
     * Constructor
     * @return void
     */
    public function __construct()
    {
        // assigning models
        $this->form_groups_model = new FormGroupsModel();
        $this->form_pages_model = new FormPagesModel();
        $this->form_field_settings_model = new FormFieldSettingsModel();
        // getting records
        $form_pages = $this->form_pages_model->orderBy('title', 'ASC')->findAll();
        $this->data['form_pages'] = $form_pages;
    }
    /**
     * List all records
     * @return void
     */
    public function index()
    {
        // display title
        $this->data['content_title'] = 'From groups';
        $this->data['content_subtitle'] = 'List';
        // active menu item flag
        $this->data['active_menu'] = 'form_groups';
        // getting records
        $form_groups = $this->form_groups_model->where('active', 1)->orderBy('title', 'ASC')->findAll();
        $this->data['form_groups'] = $form_groups;
        // rendering view
        $this->render_page('pages/form_groups');
    }
    /**
     * Add record
     * @return void|redirect
     */
    public function add()
    {
        // display title
        $this->data['content_title'] = 'From groups';
        $this->data['content_subtitle'] = 'Add';
        // active menu item flag
        $this->data['active_menu'] = 'form_groups';

        // validation rules
        $this->validation->setRules([
            'title' => [
                'label' => 'title',
                'rules' => 'trim|required|max_length[100]',
            ],
            'slug' => [
                'label' => 'slug',
                'rules' => 'trim|required|alpha_dash|max_length[100]|is_unique[form_groups.slug]',
            ],
            'form_page' => [
                'label' => 'page',
                'rules' => 'trim|required|is_natural_no_zero',
            ],
        ]);
        // checking requested method is post
        if ($this->request->getMethod() == 'post') {
            // validating data
            if ($this->validation->withRequest($this->request)->run()) {
                $input_data = [];
                $input_data['title'] = $this->request->getPost('title');
                $input_data['slug'] = $this->request->getPost('slug');
                $input_data['form_page'] = $this->request->getPost('form_page');
                $input_data['created_by'] =  $_SESSION['user_id'];
                $input_data['active'] = '1';
                $this->form_groups_model->insert($input_data);
                $this->generate_message('toastr_success', 'created', 'form group');
                return redirect()->to(current_url());
            }
        }
        // rendering view
        $this->render_page('pages/form_groups_add');
    }

    /**
     * Edit record
     * @param int $id
     * @return void|redirect
     */
    public function edit(int $id)
    {
        // display title
        $this->data['content_title'] = 'From groups';
        $this->data['content_subtitle'] = 'Edit';
        // active menu item flag
        $this->data['active_menu'] = 'form_groups';
        $form_group = $this->form_groups_model->where(['id' => $id, 'active' => 1])->find();
        if ($form_group) {
            $form_group = $form_group[0];
        } else {
            $this->generate_message('toastr_error', 'invalid', 'form group');
            return  redirect()->back();
        }
        $this->data['form_group'] = $form_group;
        $form_field_settings = $this->form_field_settings_model->where(['form_group' => $id])->findAll();
        if ($form_field_settings) {
            $form_field_settings = $form_field_settings[0];
        }
        $this->data['form_field_settings'] = $form_field_settings;
        // validation rules
        $validation_rules = [];
        $validation_rules['title'] = [
            'label' => 'title',
            'rules' => 'trim|required|max_length[100]',
        ];
        $validation_rules['slug'] = [
            'label' => 'slug',
            'rules' => 'trim|required|alpha_dash|max_length[100]|is_unique[form_groups.slug,id,' . $id . ']',
        ];
        if (!$form_field_settings) {
            $validation_rules['form_page'] = [
                'label' => 'page',
                'rules' => 'trim|required|is_natural_no_zero',
            ];
        }

        $this->validation->setRules($validation_rules);
        // validating post request
        if ($this->request->getPost() && $this->validation->withRequest($this->request)->run()) {
            $input_data = [];
            $input_data['title'] = $this->request->getPost('title');
            $input_data['slug'] = $this->request->getPost('slug');
            if (!$form_field_settings) {
                $input_data['form_page'] = $this->request->getPost('form_page');
            }
            $input_data['updated_by'] =  $_SESSION['user_id'];
            $this->form_groups_model->update($id, $input_data);
            $this->generate_message('toastr_success', 'updated', 'form group');
            return redirect()->to(current_url());
        }
        // rendering view
        $this->render_page('pages/form_groups_edit');
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
        $this->form_groups_model->update($id, $input_data);
        $this->generate_message('toastr_success', 'deleted', 'form group');
        return redirect()->back();
    }
}
