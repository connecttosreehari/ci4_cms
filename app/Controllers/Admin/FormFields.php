<?php

namespace App\Controllers\Admin;

use App\Controllers\AdminController;
// loading models
use App\Models\FormFieldsModel;
use App\Models\FormFieldTypesModel;
use App\Models\FormPagesModel;

class FormFields extends AdminController
{
	/**
	 * @var $form_fields_model
	 */
	protected $form_fields_model;
	/**
	 * @var $form_field_types_model
	 */
	protected $form_field_types_model;
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
		$this->form_fields_model = new FormFieldsModel();
		$this->form_field_types_model = new FormFieldTypesModel();
		$this->form_pages_model = new FormPagesModel();
		// getting records
		$form_field_types = $this->form_field_types_model->orderBy('title', 'ASC')->findAll();
		$this->data['field_types'] = $form_field_types;
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
		$this->data['content_title'] = 'Form groups';
		$this->data['content_subtitle'] = 'List';
		// active menu item flag
		$this->data['active_menu'] = 'form_fields';
		// getting records
		$form_fields = $this->form_fields_model->fetch_data(['active' => 1]);
		$this->data['form_fields'] = $form_fields;
		// rendering view
		$this->render_page('pages/form_fields');
	}
	/**
	 * Add data
	 * @return void|redirect
	 */
	public function add()
	{
		// display title
		$this->data['content_title'] = 'Form groups';
		$this->data['content_subtitle'] = 'Add';
		// active menu item flag
		$this->data['active_menu'] = 'form_fields';

		// validation rules
		$this->validation->setRules([
			'title' => [
				'label' => 'title',
				'rules' => 'trim|required|alpha_numeric_space|max_length[50]',
			],
			'identity' => [
				'label' => 'identity',
				'rules' => 'trim|required|alpha_dash|max_length[50]|is_unique[form_fields.identity]',
			],
			'field_name' => [
				'label' => 'field name',
				'rules' => 'trim|required|alpha_dash|max_length[50]',
			],
			'database_field' => [
				'label' => 'database field',
				'rules' => 'trim|permit_empty|alpha_dash|max_length[50]',
			],
			'field_type' => [
				'label' => 'type',
				'rules' => 'trim|required|is_natural_no_zero|is_not_unique[form_field_types.id,id,{field_type}]',
			],
			'form_page' => [
                'label' => 'page',
                'rules' => 'trim|required|is_natural_no_zero',
            ],
		]);
		// checking requested method is post
		if ($this->request->getMethod() == 'post' && $this->validation->withRequest($this->request)->run()) {
			$input_data = [];
			$input_data['title'] = $this->request->getPost('title');
			$input_data['identity'] = $this->request->getPost('identity');
			$input_data['field_name'] = $this->request->getPost('field_name');
			$input_data['database_field'] = $this->request->getPost('database_field');
			$input_data['field_type'] = $this->request->getPost('field_type');
			$input_data['form_page'] = $this->request->getPost('form_page');
			$input_data['created_by'] =  $_SESSION['user_id'];
			$input_data['active'] = '1';
			$this->form_fields_model->insert($input_data);
			$this->generate_message('toastr_success', 'created', 'form field');
			return redirect()->to(current_url());
		}

		// rendering view
		$this->render_page('pages/form_fields_add');
	}

	/**
	 * Edit data
	 * @param int $id
	 * @return void|redirect
	 */
	public function edit(int $id)
	{
		// display title
		$this->data['content_title'] = 'Form fields';
		$this->data['content_subtitle'] = 'Edit';
		// active menu item flag
		$this->data['active_menu'] = 'form_fields';
		$form_field = $this->form_fields_model->where(['id' => $id, 'active' => 1])->find();
		if ($form_field) {
			$form_field = $form_field[0];
		} else {
			$this->generate_message('toastr_error', 'invalid', 'form field');
			return  redirect()->back();
		}
		$this->data['form_field'] = $form_field;
		// validation rules
		$this->validation->setRules([
			'title' => [
				'label' => 'title',
				'rules' => 'trim|required|alpha_numeric_space|max_length[50]',
			],
			'identity' => [
				'label' => 'identity',
				'rules' => 'trim|required|alpha_dash|max_length[50]|is_unique[form_fields.identity,id,' . $id . ']',
			],
			'field_name' => [
				'label' => 'field name',
				'rules' => 'trim|required|alpha_dash|max_length[50]',
			],
			'database_field' => [
				'label' => 'database field',
				'rules' => 'trim|permit_empty|alpha_dash|max_length[50]',
			],
			'field_type' => [
				'label' => 'type',
				'rules' => 'trim|required|is_natural_no_zero|is_not_unique[form_field_types.id,id,{field_type}]',
			],
			'form_page' => [
                'label' => 'page',
                'rules' => 'trim|required|is_natural_no_zero',
            ],
		]);
		// validating post request
		if ($this->request->getPost() && $this->validation->withRequest($this->request)->run()) {
			$input_data = [];
			$input_data['title'] = $this->request->getPost('title');
			$input_data['identity'] = $this->request->getPost('identity');
			$input_data['field_name'] = $this->request->getPost('field_name');
			$input_data['database_field'] = $this->request->getPost('database_field');
			$input_data['field_type'] = $this->request->getPost('field_type');
			$input_data['form_page'] = $this->request->getPost('form_page');
			$input_data['updated_by'] =  $_SESSION['user_id'];
			$this->form_fields_model->update($id, $input_data);
			$this->generate_message('toastr_success', 'updated', 'form field');
			return redirect()->to(current_url());
		}
		// rendering view
		$this->render_page('pages/form_fields_edit');
	}

	/**
	 * Disable specfic record
	 * @param $id
	 * @return redirect
	 */
	public function disable($id)
	{
		$input_data = [];
		$input_data['active'] = 2;
		$this->form_fields_model->update($id, $input_data);
		$this->generate_message('toastr_success', 'deleted', 'form field');
		return redirect()->back();
	}
}
