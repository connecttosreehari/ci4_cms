<?php

namespace App\Controllers\Admin;

use App\Controllers\AdminController;
// loading models
use App\Models\FormGroupsModel;
use App\Models\FormFieldsModel;
use App\Models\FormFieldTypesModel;
use App\Models\FormFieldSettingsModel;
use App\Models\FormPagesModel;

class FormFieldSettings extends AdminController
{
	/**
	 * @var $form_groups_model
	 */
	protected $form_groups_model;
	/**
	 * @var $form_fields_model
	 */
	protected $form_fields_model;
	/**
	 * @var $form_field_types_model
	 */
	protected $form_field_types_model;
	/**
	 * @var $form_field_settings_model
	 */
	protected $form_field_settings_model;
	/**
	 * @var $form_pages_model
	 */
	protected $form_pages_model;
	/**
	 * Constructor
	 * @return void
	 */
	public function __construct()
	{
		// assigning models 
		$this->form_groups_model = new FormGroupsModel();
		$this->form_fields_model = new FormFieldsModel();
		$this->form_field_types_model = new FormFieldTypesModel();
		$this->form_field_settings_model = new FormFieldSettingsModel();
	}

	/**
	 * getting all the field settings of form group
	 * @param int $group_id
	 * @return void 
	 */
	public function group(int $group_id)
	{
		// active menu item flag
		$this->data['active_menu'] = 'form_groups';
		// getting form group
		$form_group = $this->form_groups_model->where(['id' => $group_id, 'active' => 1])->find();
		if ($form_group) {
			$form_group = $form_group[0];
		} else {
			$this->generate_message('toastr_error', 'invalid', 'form group');
			return  redirect()->back();
		}
		$this->data['form_group'] = $form_group;
		// display title
		$this->data['content_title'] = $form_group->title;
		$this->data['content_subtitle'] = 'Fields';
		// getting form group field settings
		$form_field_settings = $this->form_field_settings_model->fetch_data(['active' => 1, 'group_id' => $group_id]);
		$this->data['form_field_settings'] = $form_field_settings;
		// rendering view
		$this->render_page('pages/form_field_settings');
	}

	/**
	 * add form field to form group
	 * @param int $group_id
	 * @return void 
	 */
	public function add(int $group_id)
	{

		// active menu item flag
		$this->data['active_menu'] = 'form_groups';
		$form_group = $this->form_groups_model->where(['id' => $group_id, 'active' => 1])->find();
		if ($form_group) {
			$form_group = $form_group[0];
		} else {
			$this->generate_message('toastr_error', 'invalid', 'form group');
			return  redirect()->back();
		}
		$this->data['form_group'] = $form_group;
		// display title
		$this->data['content_title'] = $form_group->title;
		$this->data['content_subtitle'] = 'Fields';
		$form_fields = $this->form_fields_model->where(['active' => 1, 'form_page' => $form_group->form_page])->findAll();
		$this->data['form_fields'] = $form_fields;

		// validation rules
		$this->validation->setRules([
			'form_field' => [
				'label' => 'type',
				'rules' => 'trim|required|is_natural_no_zero|is_not_unique[form_fields.id,id,{form_field}]',
			],
		]);
		// validating post request
		if ($this->request->getPost() && $this->validation->withRequest($this->request)->run()) {
			$field_id = $this->request->getPost('form_field');
			$form_field_setting = $this->form_field_settings_model->where(['active' => 1, 'form_group' => $group_id, 'form_field' => $field_id])->find();
			if ($form_field_setting) {
				$this->generate_message('toastr_error', 'exists', 'form field');
				return  redirect()->back();
			}
			$input_data = [];
			$input_data['form_field'] = $field_id;
			$input_data['form_group'] = $group_id;
			$input_data['created_by'] =  $_SESSION['user_id'];
			$input_data['active'] = '1';
			$this->form_field_settings_model->insert($input_data);
			$this->generate_message('toastr_success', 'added', 'field');
			return redirect()->to(current_url());
		}
		// rendering view
		$this->render_page('pages/form_field_settings_add');
	}
	/**
	 * edit form field settings to form group
	 * @param int $group_id
	 * @param int $form_field 
	 * @return void 
	 */
	public function edit(int $group_id, int $field_id)
	{

		// active menu item flag
		$this->data['active_menu'] = 'form_groups';
		$form_group = $this->form_groups_model->where(['id' => $group_id, 'active' => 1])->find();
		if ($form_group) {
			$form_group = $form_group[0];
		} else {
			$this->generate_message('toastr_error', 'invalid', 'form group');
			return  redirect()->back();
		}
		$this->data['form_group'] = $form_group;

		$form_field = $this->form_fields_model->where(['id' => $field_id, 'active' => 1])->find();
		if ($form_field) {
			$form_field = $form_field[0];
		} else {
			$this->generate_message('toastr_error', 'invalid', 'form field');
			return  redirect()->back();
		}
		$this->data['form_field'] = $form_field;
		// display title
		$this->data['content_title'] = $form_group->title;
		$this->data['content_subtitle'] = $form_field->title . ' Configuration';

		$form_field_setting = $this->form_field_settings_model->where(['form_group' => $group_id, 'form_field' => $field_id])->find();
		if ($form_field_setting) {
			$form_field_setting = $form_field_setting[0];
		} else {
			$this->generate_message('toastr_error', 'invalid', 'field setting');
			return  redirect()->back();
		}
		$this->data['form_field_setting'] = $form_field_setting;

		$file_form_groups = $this->form_groups_model->where(['active' => 1, 'form_page' => 2])->findAll();
		$this->data['file_form_groups'] = $file_form_groups;

		if ($this->request->getPost()) {
			$settings_id = $form_field_setting->id;
			$input_data = [];
			$input_data['check_required'] = $this->request->getPost('check_required');
			$input_data['check_valid_email'] = $this->request->getPost('check_valid_email');
			$input_data['match_regex'] = $this->request->getPost('match_regex');
			$input_data['max_length'] = $this->request->getPost('max_length');
			$input_data['enable_editor'] = $this->request->getPost('enable_editor');
			$input_data['enable_multiple'] = $this->request->getPost('enable_multiple');
			$input_data['allowed_extensions'] = $this->request->getPost('allowed_extensions');
			$input_data['enable_file_edit'] = $this->request->getPost('enable_file_edit');
			$input_data['enable_file_delete'] = $this->request->getPost('enable_file_delete');
			$input_data['enable_file_order'] = $this->request->getPost('enable_file_order');
			$input_data['file_form_group'] = $this->request->getPost('file_form_group');
			$input_data['min_width'] = $this->request->getPost('min_width');
			$input_data['min_height'] = $this->request->getPost('min_height');
			$input_data['max_width'] = $this->request->getPost('max_width');
			$input_data['max_height'] = $this->request->getPost('max_height');
			$input_data['thumb_width'] = $this->request->getPost('thumb_width');
			$input_data['thumb_height'] = $this->request->getPost('thumb_height');
			$input_data['max_size'] = $this->request->getPost('max_size');
			$input_data['enable_resize'] = $this->request->getPost('enable_resize');
			$input_data['updated_by'] = $_SESSION['user_id'];
			$input_data['active'] = $this->request->getPost('form_field_status');
			$this->form_field_settings_model->update($settings_id, $input_data);
			$this->generate_message('toastr_success', 'saved', 'field configuration');
			return redirect()->to(current_url());
		}
		// rendering view
		$this->render_page('pages/form_field_settings_edit');
	}

	/**
	 * Disable specfic record
	 * @param $id
	 * @return redirect
	 */
	public function disable($form_group_id, $id)
	{
		$input_data = [];
		$input_data['active'] = 2;
		$this->form_field_settings_model->where(['id' => $id, 'form_group' => $form_group_id])->delete();
		$this->generate_message('toastr_success', 'deleted', 'form field');
		return redirect()->back();
	}
}
