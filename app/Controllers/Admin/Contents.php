<?php

namespace App\Controllers\Admin;

use App\Controllers\AdminController;
//loading models
use App\Models\ContentGroupsModel;
use App\Models\ContentsModel;
use App\Models\ContentTranslationsModel;
use App\Models\ContentFilesModel;
use App\Models\ContentFileDetailsModel;
use App\Models\ContentFileGroupsModel;
use App\Models\ContentFileTypesModel;
use App\Models\FormGroupsModel;
use App\Models\FormFieldsModel;
use App\Models\FormFieldTypesModel;
use App\Models\FormFieldSettingsModel;
use App\Models\LanguagesModel;

class Contents extends AdminController
{
	/**
	 * @var $contents_model
	 */
	protected $contents_model;
	/**
	 * @var $content_translations_model
	 */
	protected $content_translations_model;
	/**
	 * @var $content_groups_model
	 */
	protected $content_groups_model;
	/**
	 * @var $content_file_groups_model
	 */
	protected $content_file_groups_model;
	/**
	 * @var $content_files_model
	 */
	protected $content_files_model;
	/**
	 * @var $content_file_details_model
	 */
	protected $content_file_details_model;
	/**
	 * @var $content_file_types_model
	 */
	protected $content_file_types_model;
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
	 * @var $languages_model
	 */
	protected $languages_model;
	/**
	 * @var $image_lib
	 */
	protected $image_lib;
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
		$this->contents_model = new ContentsModel();
		$this->content_translations_model = new ContentTranslationsModel();
		$this->content_groups_model = new ContentGroupsModel();
		$this->content_files_model = new ContentFilesModel();
		$this->content_file_details_model = new ContentFileDetailsModel();
		$this->content_file_groups_model = new ContentFileGroupsModel();
		$this->content_file_types_model = new ContentFileTypesModel();
		$this->languages_model = new LanguagesModel();

		// loading library
		$this->image_lib = \Config\Services::image();
		// getting languages
		$languages = $this->languages_model->where('active', 1)->findAll();
		$this->data['languages'] = $languages;
		// getting form groups
		$form_groups = $this->form_groups_model->where(['active' => 1, 'form_page' => 1])->orderBy('title', 'ASC')->findAll();
		$this->data['form_groups'] = $form_groups;
	}

	/** 
	 * getting all contents by group
	 * @param int $id
	 * @param string|null $lang
	 * @param return void
	 */
	public function list(int $id,  $lang = null)
	{
		//setting default language
		if ($lang == null) {
			$lang = $this->site_lang;
		}
		$content_language = $this->languages_model->where(['code' => $lang, 'active' => 1])->find();
		if ($content_language) {
			$content_language = $content_language[0];
		} else {
			$this->generate_message('toastr_error', 'invalid', 'language');
			return  redirect()->back();
		}
		$this->data['content_language'] = $content_language;
		//getting content group
		$content_group = $this->content_groups_model->where(['id' => $id, 'active' => 1])->orderBy('title', 'ASC')->find();
		if ($content_group) {
			$content_group = $content_group[0];
		} else {
			$this->generate_message('toastr_error', 'invalid', 'content group');
			return  redirect()->back();
		}
		$this->data['content_group'] = $content_group;

		// display title
		$this->data['content_title'] = $content_group->title;
		$this->data['content_subtitle'] = 'List';
		// active menu item flag
		$this->data['active_menu'] = 'content_group_' . $id;

		$filter = [];
		$filter['content_group'] = $id;
		$filter['language'] = $lang;
		$filter['active'] = 1;
		$content_translations = $this->contents_model->fetch_data($filter);
		$this->data['content_translations'] = $content_translations;
		if ($content_translations) {
			$validation_rules = [];
			foreach ($content_translations as $content_translation) {
				// validation rules
				$validation_rules['content_order_' . $content_translation->content_id] = [
					'label' => 'content order',
					'rules' => 'trim|permit_empty|is_natural_no_zero',
				];
			}
			$this->validation->setRules($validation_rules);
		}
		// validating post request
		if ($this->request->getPost()) {
			if ($content_translations) {
				if ($this->validation->withRequest($this->request)->run()) {
					foreach ($content_translations as $content_translation) {
						$content_order = $this->request->getPost('content_order_' . $content_translation->content_id);
						$this->content_translations_model->update_content_order($content_translation->content_id, $content_order);
					}
					$this->generate_message('toastr_success', 'updated', 'order');
					return redirect()->to(current_url());
				} else {
					$this->generate_message('toastr_error', 'invalid', 'order');
				}
			}
		}
		// rendering view
		$this->render_page('pages/contents');
	}

	/**
	 * Add record
	 * @param int $group_id
	 * @param string|null $lang
	 * @param int|null $custom_form_group_id
	 * @return void|redirect
	 */
	public function add(int $group_id, $lang = null, int $custom_form_group_id = null)
	{
		//setting default language
		if ($lang == null) {
			$lang = $this->site_lang;
		}
		$content_language = $this->languages_model->where(['code' => $lang, 'active' => 1])->find();
		if ($content_language) {
			$content_language = $content_language[0];
		} else {
			$this->generate_message('toastr_error', 'invalid', 'language');
			return  redirect()->back();
		}
		$this->data['content_language'] = $content_language;

		// getting content group
		$content_group = $this->content_groups_model->where(['id' => $group_id, 'active' => 1])->orderBy('title', 'ASC')->find();
		if ($content_group) {
			$content_group = $content_group[0];
		} else {
			$this->generate_message('toastr_error', 'invalid', 'content group');
			return  redirect()->back();
		}
		$this->data['content_group'] = $content_group;
		if ($content_group->enable_add != 1) {
			$this->generate_message('toastr_error', 'denied', 'content add');
			return  redirect()->back();
		}
		$form_group_id = $content_group->form_group;
		// overide the content group form validation and settings
		if ($custom_form_group_id > 0 && $custom_form_group_id != $form_group_id) {
			$form_group_id = $custom_form_group_id;
		}
		$this->data['custom_form_group_id'] = $custom_form_group_id;
		// getting form group 
		$content_form_group = $this->form_groups_model->where(['id' => $form_group_id, 'active' => 1])->find();
		if ($content_form_group) {
			$content_form_group = $content_form_group[0];
		} else {
			$this->generate_message('toastr_error', 'invalid', 'form group');
			return  redirect()->back();
		}
		$this->data['content_form_group'] = $content_form_group;


		// display title
		$this->data['content_title'] = $content_group->title;
		$this->data['content_subtitle'] = 'Add';

		// active menu item flag
		$this->data['active_menu'] = 'content_group_' . $group_id;

		// validation rules
		$content_fields = $this->content_validation($form_group_id);
		$this->data['content_fields'] = $content_fields;
		$validation_rules = [];
		if (!empty($content_fields['title']['settings']) && $content_fields['title']['settings']->active == 1) {
			$validation_rules['title'] = [
				'label' => 'title',
				'rules' => $content_fields['title']['validations'],
			];
		}
		if (!empty($content_fields['slug']['settings']) && $content_fields['slug']['settings']->active == 1) {
			$validation_rules['slug'] = [
				'label' => 'slug',
				'rules' => $content_fields['slug']['validations'],
			];
		}
		if (!empty($content_fields['subtitle']['settings']) && $content_fields['subtitle']['settings']->active == 1) {
			$validation_rules['subtitle'] = [
				'label' => 'subtitle',
				'rules' => $content_fields['subtitle']['validations'],
			];
		}
		if (!empty($content_fields['short_description']['settings']) && $content_fields['short_description']['settings']->active == 1) {
			$validation_rules['short_description'] = [
				'label' => 'short description',
				'rules' => $content_fields['description']['validations'],
			];
		}
		if (!empty($content_fields['description']['settings']) && $content_fields['description']['settings']->active == 1) {
			$validation_rules['description'] = [
				'label' => 'description',
				'rules' => $content_fields['description']['validations'],
			];
		}
		if (!empty($content_fields['image_upload']['settings']) && $content_fields['image_upload']['settings']->active == 1) {
			$validation_rules['image_upload[]'] = [
				'label' => 'image upload',
				'rules' => $content_fields['image_upload']['validations'],
			];
		}
		if (!empty($content_fields['document_upload']['settings']) && $content_fields['document_upload']['settings']->active == 1) {
			$validation_rules['document_upload[]'] = [
				'label' => 'document upload',
				'rules' => $content_fields['document_upload']['validations'],
			];
		}
		if (!empty($content_fields['link']['settings']) && $content_fields['link']['settings']->active == 1) {
			$validation_rules['link'] = [
				'label' => 'link',
				'rules' => $content_fields['link']['validations'],
			];
		}
		if (!empty($content_fields['button_name']['settings']) && $content_fields['button_name']['settings']->active == 1) {
			$validation_rules['button_name'] = [
				'label' => 'button name',
				'rules' => $content_fields['button_name']['validations'],
			];
		}
		if (!empty($content_fields['icon']['settings']) && $content_fields['icon']['settings']->active == 1) {
			$validation_rules['icon'] = [
				'label' => 'icon',
				'rules' => $content_fields['icon']['validations'],
			];
		}
		if (!empty($content_fields['full_name']['settings']) && $content_fields['full_name']['settings']->active == 1) {
			$validation_rules['full_name'] = [
				'label' => 'full name',
				'rules' => $content_fields['full_name']['validations'],
			];
		}
		if (!empty($content_fields['address']['settings']) && $content_fields['address']['settings']->active == 1) {
			$validation_rules['address'] = [
				'label' => 'address',
				'rules' => $content_fields['address']['validations'],
			];
		}
		if (!empty($content_fields['email']['settings']) && $content_fields['email']['settings']->active == 1) {
			$validation_rules['email'] = [
				'label' => 'email',
				'rules' => $content_fields['email']['validations'],
			];
		}
		if (!empty($content_fields['phone']['settings']) && $content_fields['phone']['settings']->active == 1) {
			$validation_rules['phone'] = [
				'label' => 'phone',
				'rules' => $content_fields['phone']['validations'],
			];
		}
		if (!empty($content_fields['fax']['settings']) && $content_fields['fax']['settings']->active == 1) {
			$validation_rules['fax'] = [
				'label' => 'fax',
				'rules' => $content_fields['fax']['validations'],
			];
		}
		if (!empty($content_fields['meta_title']['settings']) && $content_fields['meta_title']['settings']->active == 1) {
			$validation_rules['meta_title'] = [
				'label' => 'title',
				'rules' => $content_fields['meta_title']['validations'],
			];
		}
		if (!empty($content_fields['meta_keyword']['settings']) && $content_fields['meta_keyword']['settings']->active == 1) {
			$validation_rules['meta_keyword'] = [
				'label' => 'meta keyword',
				'rules' => $content_fields['meta_keyword']['validations'],
			];
		}
		if (!empty($content_fields['meta_description']['settings']) && $content_fields['meta_description']['settings']->active == 1) {
			$validation_rules['meta_description'] = [
				'label' => 'meta description',
				'rules' => $content_fields['meta_description']['validations'],
			];
		}
		if (!empty($content_fields['meta_canonical_url']['settings']) && $content_fields['meta_canonical_url']['settings']->active == 1) {
			$validation_rules['meta_canonical_url'] = [
				'label' => 'meta canonical',
				'rules' => $content_fields['meta_canonical_url']['validations'],
			];
		}
		$this->validation->setRules($validation_rules);
		// checking requested method is post
		if ($this->request->getMethod() == 'post') {
			// validating data
			if ($this->validation->withRequest($this->request)->run()) {
				$this->db->transStart();
				$input_data = [];
				$input_data['content_group'] = $group_id;
				if ($content_group->enable_custom_form_group == 1) {
					$input_data['custom_form_group'] = $custom_form_group_id;
				}
				$input_data['active'] = 1;
				$content_id = $this->contents_model->insert($input_data);
				$input_data = [];
				$input_data['content'] = $content_id;
				$input_data['title'] = $this->request->getPost('title');
				$input_data['slug'] = $this->request->getPost('slug');
				$input_data['subtitle'] = $this->request->getPost('subtitle');
				$input_data['short_description'] = $this->request->getPost('short_description');
				$input_data['description'] = $this->request->getPost('description');
				$input_data['link'] = $this->request->getPost('link');
				$input_data['button_name'] = $this->request->getPost('button_name');
				$input_data['icon'] = $this->request->getPost('icon');
				$input_data['full_name'] = $this->request->getPost('full_name');
				$input_data['address'] = $this->request->getPost('address');
				$input_data['email'] = $this->request->getPost('email');
				$input_data['phone'] = $this->request->getPost('phone');
				$input_data['fax'] = $this->request->getPost('fax');
				$input_data['meta_title'] = $this->request->getPost('meta_title');
				$input_data['meta_keyword'] = $this->request->getPost('meta_keyword');
				$input_data['meta_description'] = $this->request->getPost('meta_description');
				$input_data['meta_canonical_url'] = $this->request->getPost('meta_canonical_url');
				$input_data['language'] = $lang;
				$input_data['created_by'] =  $_SESSION['user_id'];
				$input_data['active'] = '1';
				$translation_id = $this->content_translations_model->insert($input_data);
				$this->upload_files($content_id, $translation_id, $content_fields, $lang);
				$this->db->transComplete();
				$this->generate_message('toastr_success', 'added', 'content');
				return redirect()->route('contents_add', [$group_id, $lang]);
			}
		}
		// rendering view
		$this->render_page('pages/contents_add');
	}

	/**
	 * Edit record
	 * @param int $id
	 * @param string|null $lang
	 * @param int|null $custom_form_group_id
	 * @return void
	 */
	public function edit(int $id,  $lang = null, int $custom_form_group_id = null)
	{
		//setting default language
		if ($lang == null) {
			$lang = $this->site_lang;
		}
		$content_language = $this->languages_model->where(['code' => $lang, 'active' => 1])->find();
		if ($content_language) {
			$content_language = $content_language[0];
		} else {
			$this->generate_message('toastr_error', 'invalid', 'language');
			return  redirect()->back();
		}
		$this->data['content_language'] = $content_language;
		$content = $this->contents_model->where(['id' => $id, 'active' => 1])->find();
		if ($content) {
			$content = $content[0];
		} else {
			$this->generate_message('toastr_error', 'invalid', 'content');
			return redirect()->back();
		}
		$this->data['content'] = $content;
		// getting content group
		$content_group = $this->content_groups_model->where(['id' => $content->content_group, 'active' => 1])->orderBy('title', 'ASC')->find();
		if ($content_group) {
			$content_group = $content_group[0];
		} else {
			$this->generate_message('toastr_error', 'invalid', 'content group');
			return  redirect()->back();
		}
		$this->data['content_group'] = $content_group;
		if ($content_group->enable_edit != 1) {
			$this->generate_message('toastr_error', 'denied', 'content edit');
			return  redirect()->back();
		}

		$form_group_id = $content_group->form_group;
		// overide the content group form validation and settings
		if ($custom_form_group_id == null &&  $content->custom_form_group > 0 && $content->custom_form_group != $form_group_id) {
			$form_group_id = $content->custom_form_group;
			$custom_form_group_id = $form_group_id;
		} else if ($custom_form_group_id > 0 && $custom_form_group_id != $form_group_id) {
			$form_group_id = $custom_form_group_id;
		}
		$this->data['custom_form_group_id'] = $custom_form_group_id;
		// getting form group 
		$content_form_group = $this->form_groups_model->where(['id' => $form_group_id, 'active' => 1])->find();
		if ($content_form_group) {
			$content_form_group = $content_form_group[0];
		} else {
			$this->generate_message('toastr_error', 'invalid', 'form group');
			return  redirect()->back();
		}
		$this->data['content_form_group'] = $content_form_group;

		// display title
		$this->data['content_title'] = $content_group->title;
		$this->data['content_subtitle'] = 'Edit';
		// active menu item flag
		$this->data['active_menu'] = 'content_group_' . $content->content_group;

		$content_translation = '';
		$filter = [];
		$filter['id'] = $id;
		$filter['language'] = $lang;
		$filter['active'] = 1;
		$content_translations = $this->contents_model->fetch_data($filter);
		$content_translation_id = null;

		if ($content_translations) {
			$content_translation = $content_translations[0];
			$content_translation_id = $content_translation->id;
		}
		$this->data['content_translation'] = $content_translation;
		$file_groups = $this->content_file_groups_model->findAll();
		$content_file_details = [];
		if ($file_groups) {
			foreach ($file_groups as $file_group) {
				$filter = [];
				$filter['content_id'] = $id;
				$filter['file_group'] = $file_group->id;
				$filter['language'] = $lang;
				$content_file_details[$file_group->id] = $this->content_files_model->fetch_data($filter);
			}
		}
		$this->data['content_file_details'] = $content_file_details;
		$content_order = $this->content_translations_model->get_content_order($id, $this->site_lang);
		// validation rules
		$content_fields = $this->content_validation($form_group_id, $content_translation_id);
		$this->data['content_fields'] = $content_fields;
		$validation_rules = [];
		if (!empty($content_fields['title']['settings']) && $content_fields['title']['settings']->active == 1) {
			$validation_rules['title'] = [
				'label' => 'title',
				'rules' => $content_fields['title']['validations'],
			];
		}
		if (!empty($content_fields['slug']['settings']) && $content_fields['slug']['settings']->active == 1) {
			$validation_rules['slug'] = [
				'label' => 'slug',
				'rules' => $content_fields['slug']['validations'],
			];
		}
		if (!empty($content_fields['subtitle']['settings']) && $content_fields['subtitle']['settings']->active == 1) {
			$validation_rules['subtitle'] = [
				'label' => 'subtitle',
				'rules' => $content_fields['subtitle']['validations'],
			];
		}
		if (!empty($content_fields['short_description']['settings']) && $content_fields['short_description']['settings']->active == 1) {
			$validation_rules['short_description'] = [
				'label' => 'short description',
				'rules' => $content_fields['description']['validations'],
			];
		}
		if (!empty($content_fields['description']['settings']) && $content_fields['description']['settings']->active == 1) {
			$validation_rules['description'] = [
				'label' => 'description',
				'rules' => $content_fields['description']['validations'],
			];
		}
		if (!empty($content_fields['image_upload']['settings']) && $content_fields['image_upload']['settings']->active == 1) {
			$validation_rules['image_upload[]'] = [
				'label' => 'image upload',
				'rules' => $content_fields['image_upload']['validations'],
			];
		}
		if (!empty($content_fields['document_upload']['settings']) && $content_fields['document_upload']['settings']->active == 1) {
			$validation_rules['document_upload[]'] = [
				'label' => 'document upload',
				'rules' => $content_fields['document_upload']['validations'],
			];
		}
		if (!empty($content_fields['link']['settings']) && $content_fields['link']['settings']->active == 1) {
			$validation_rules['link'] = [
				'label' => 'link',
				'rules' => $content_fields['link']['validations'],
			];
		}
		if (!empty($content_fields['button_name']['settings']) && $content_fields['button_name']['settings']->active == 1) {
			$validation_rules['button_name'] = [
				'label' => 'button name',
				'rules' => $content_fields['button_name']['validations'],
			];
		}
		if (!empty($content_fields['icon']['settings']) && $content_fields['icon']['settings']->active == 1) {
			$validation_rules['icon'] = [
				'label' => 'icon',
				'rules' => $content_fields['icon']['validations'],
			];
		}
		if (!empty($content_fields['full_name']['settings']) && $content_fields['full_name']['settings']->active == 1) {
			$validation_rules['full_name'] = [
				'label' => 'full name',
				'rules' => $content_fields['full_name']['validations'],
			];
		}
		if (!empty($content_fields['address']['settings']) && $content_fields['address']['settings']->active == 1) {
			$validation_rules['address'] = [
				'label' => 'address',
				'rules' => $content_fields['address']['validations'],
			];
		}
		if (!empty($content_fields['email']['settings']) && $content_fields['email']['settings']->active == 1) {
			$validation_rules['email'] = [
				'label' => 'email',
				'rules' => $content_fields['email']['validations'],
			];
		}
		if (!empty($content_fields['phone']['settings']) && $content_fields['phone']['settings']->active == 1) {
			$validation_rules['phone'] = [
				'label' => 'phone',
				'rules' => $content_fields['phone']['validations'],
			];
		}
		if (!empty($content_fields['fax']['settings']) && $content_fields['fax']['settings']->active == 1) {
			$validation_rules['fax'] = [
				'label' => 'fax',
				'rules' => $content_fields['fax']['validations'],
			];
		}
		if (!empty($content_fields['meta_title']['settings']) && $content_fields['meta_title']['settings']->active == 1) {
			$validation_rules['meta_title'] = [
				'label' => 'title',
				'rules' => $content_fields['meta_title']['validations'],
			];
		}
		if (!empty($content_fields['meta_keyword']['settings']) && $content_fields['meta_keyword']['settings']->active == 1) {
			$validation_rules['meta_keyword'] = [
				'label' => 'meta keyword',
				'rules' => $content_fields['meta_keyword']['validations'],
			];
		}
		if (!empty($content_fields['meta_description']['settings']) && $content_fields['meta_description']['settings']->active == 1) {
			$validation_rules['meta_description'] = [
				'label' => 'meta description',
				'rules' => $content_fields['meta_description']['validations'],
			];
		}
		if (!empty($content_fields['meta_canonical_url']['settings']) && $content_fields['meta_canonical_url']['settings']->active == 1) {
			$validation_rules['meta_canonical_url'] = [
				'label' => 'meta canonical',
				'rules' => $content_fields['meta_canonical_url']['validations'],
			];
		}
		$this->validation->setRules($validation_rules);

		// validating post request
		if ($this->request->getPost() && $this->validation->withRequest($this->request)->run()) {
			$this->db->transStart();
			if ($content_group->enable_custom_form_group == 1) {
				$input_data = [];
				$input_data['custom_form_group'] = $custom_form_group_id;
				$this->contents_model->update($id, $input_data);
			}
			$input_data = [];
			$input_data['content'] = $id;
			$input_data['title'] = $this->request->getPost('title');
			$input_data['slug'] = $this->request->getPost('slug');
			$input_data['subtitle'] = $this->request->getPost('subtitle');
			$input_data['short_description'] = $this->request->getPost('short_description');
			$input_data['description'] = $this->request->getPost('description');
			$input_data['link'] = $this->request->getPost('link');
			$input_data['button_name'] = $this->request->getPost('button_name');
			$input_data['icon'] = $this->request->getPost('icon');
			$input_data['full_name'] = $this->request->getPost('full_name');
			$input_data['address'] = $this->request->getPost('address');
			$input_data['email'] = $this->request->getPost('email');
			$input_data['phone'] = $this->request->getPost('phone');
			$input_data['fax'] = $this->request->getPost('fax');
			$input_data['meta_title'] = $this->request->getPost('meta_title');
			$input_data['meta_keyword'] = $this->request->getPost('meta_keyword');
			$input_data['meta_description'] = $this->request->getPost('meta_description');
			$input_data['meta_canonical_url'] = $this->request->getPost('meta_canonical_url');
			$input_data['content_order'] = $content_order;
			if ($content_translation) {
				$input_data['updated_by'] =  $_SESSION['user_id'];
				$this->content_translations_model->update($content_translation->id, $input_data);
			} else {
				$input_data['language'] = $lang;
				$input_data['content'] = $id;
				$input_data['created_by'] =  $_SESSION['user_id'];
				$input_data['active'] = '1';
				$this->content_translations_model->insert($input_data);
			}
			$this->upload_files($id, $content_translation_id, $content_fields, $lang);
			if ($content_file_details[1]) {
				foreach ($content_file_details[1] as $content_file) {
					$file_order = $this->request->getPost('file_order_' . $content_file->id);
					$file_order = $file_order > 0 ? $file_order : 0;
					$input_data = [];
					$input_data['file_order'] = $file_order;
					$this->content_file_details_model->update($content_file->id, $input_data);
				}
			}
			$this->db->transComplete();
			$this->generate_message('toastr_success', 'updated', 'content');
			return redirect()->to(current_url());
		}

		// rendering view
		$this->render_page('pages/contents_edit');
	}
	/**
	 * uploading files 
	 * @param int $id
	 * @param int|null $translation_id
	 * @param array $settings
	 * @param string $lang
	 */
	private function upload_files(int $content_id, int $translation_id = null, array $settings, string $lang)
	{
		if ($files = $this->request->getFiles()) {
			if (!empty($files['image_upload'])) {				
				foreach ($files['image_upload'] as $file) {					
					$image_settings = $settings['image_upload']['settings'];
					$allow_multiple = $image_settings->enable_multiple;
					$allow_resize = $image_settings->enable_resize;
					$width = '1024';
					$height = '768';
					if ($image_settings->max_width > 0) {
						$width = $image_settings->max_width;
					}
					if ($image_settings->max_height > 0) {
						$height = $image_settings->max_height;
					}
					$thumb_width = '100';
					$thumb_height = '150';
					if ($image_settings->thumb_width > 0) {
						$thumb_width = $image_settings->thumb_width;
					}
					if ($image_settings->thumb_height > 0) {
						$thumb_height = $image_settings->thumb_height;
					}
					if ($file->isValid() && !$file->hasMoved()) {																	
						$ext = $file->getClientExtension();
						$file_name = $file->getRandomName();
						$file->move('uploads', $file_name);
						$image = $this->image_lib->withFile('uploads/' . $file_name);
						if ($allow_resize == 1) {
							$image->resize($width, $height, false, 'height');
						}
						$image->save('uploads/' . $file_name);
						$this->image_lib->withFile('uploads/' . $file_name)
							->resize($thumb_width, $thumb_height, $allow_resize == 1 ? false : true, 'height')
							->save('uploads/thumb_' . $file_name);
						// content file group is used to categories uploaded files in content
						$content_file_group = 1;
						// content file type image or other
						$content_file_type = 1;
						$content_file = $this->content_files_model->where(['content' => $content_id, 'content_file_group' => $content_file_group, 'content_file_type' => $content_file_type])->find();
						$content_file_id = '';
						if ($content_file && $allow_multiple != 1) {
							$content_file = $content_file[0];
							$content_file_id = $content_file->id;							
						} else {
							$input_data = [];
							$input_data['content'] = $content_id;
							$input_data['content_file_group'] = $content_file_group;
							$input_data['content_file_type'] = $content_file_type;
							$content_file_id = $this->content_files_model->insert($input_data);
							
						}
					
						$content_file_details = $this->content_file_details_model->where(['content_file' => $content_file_id, 'language' => $lang, 'active' => 1])->find();
						$input_data = [];
						$input_data['file'] = $file_name;
						if ($content_file_details) {
							$content_file_details = $content_file_details[0];
							$input_data['updated_by'] =  $_SESSION['user_id'];
							$this->content_file_details_model->update($content_file_details->id, $input_data);
						} else {
							$input_data['translation_id'] = $translation_id;
							$input_data['language'] =  $lang;
							$input_data['content_file'] = $content_file_id;
							$input_data['created_by'] =  $_SESSION['user_id'];
							$input_data['active'] =  1;
							$this->content_file_details_model->insert($input_data);
						}
					}
				}
			}
			if (!empty($files['document_upload'])) {
				foreach ($files['document_upload'] as $file) {
					$file_settings = $settings['document_upload']['settings'];
					$allow_multiple = $file_settings->enable_multiple;
					if ($file->isValid() && !$file->hasMoved()) {
						$ext = $file->getClientExtension();
						$file_name = $file->getRandomName();
						$file->move('uploads', $file_name);
						// content file group is used to categories uploaded files in content
						$content_file_group = 2;
						// content file type image or other
						$content_file_type = 2;
						$content_file = $this->content_files_model->where(['content' => $id, 'content_file_group' => $content_file_group, 'content_file_type' => $content_file_type])->find();
						$content_file_id = '';
						if ($content_file && $allow_multiple != 1) {
							$content_file = $content_file[0];
							$content_file_id = $content_file->id;
						} else {
							$input_data = [];
							$input_data['content'] = $content_id;
							$input_data['content_file_group'] = $content_file_group;
							$input_data['content_file_type'] = $content_file_type;
							$content_file_id = $this->content_files_model->insert($input_data);
						}
						$content_file_details = $this->content_file_details_model->where(['content_file' => $content_file_id, 'active' => 1])->find();
						$input_data = [];
						$input_data['file'] = $file_name;
						if ($content_file_details) {
							$content_file_details = $content_file_details[0];
							$input_data['updated_by'] =  $_SESSION['user_id'];
							$this->content_file_details_model->update($content_file_details->id, $input_data);
						} else {
							$input_data['translation_id'] = $translation_id;
							$input_data['language'] =  $lang;
							$input_data['content_file'] = $content_file_id;
							$input_data['created_by'] =  $_SESSION['user_id'];
							$input_data['active'] = 1;
							$this->content_file_details_model->insert($input_data);
						}
					}
				}
			}
		}
	}
	/**
	 * Edit file
	 * @param int $id
	 * @param int $content_id
	 * @param int $content_field_settings_id
	 * @param string|null $lang
	 * @return void|redirect
	 */
	public function file_edit(int $id, int $content_id, int $content_field_settings_id, $lang = null)
	{
		//setting default language
		if ($lang == null) {
			$lang = $this->site_lang;
		}
		$content_language = $this->languages_model->where(['code' => $lang, 'active' => 1])->find();
		if ($content_language) {
			$content_language = $content_language[0];
		} else {
			$this->generate_message('toastr_error', 'invalid', 'language');
			return  redirect()->back();
		}
		$this->data['content_language'] = $content_language;
		// display title
		$this->data['content_title'] = 'File';
		$this->data['content_subtitle'] = 'Edit';
		$content = $this->contents_model->where(['id' => $content_id, 'active' => 1])->find();
		if ($content) {
			$content = $content[0];
		} else {
			$this->generate_message('toastr_error', 'invalid', 'content');
			return redirect()->back();
		}
		$this->data['content'] = $content;
		// active menu item flag
		$this->data['active_menu'] = 'content_group_' . $content->content_group;

		$content_file_settings = $this->form_field_settings_model->where(['id' => $content_field_settings_id, 'active' => 1])->find();
		if ($content_file_settings) {
			$content_file_settings = $content_file_settings[0];
		} else {
			$this->generate_message('toastr_error', 'invalid', 'field settings');
			return redirect()->back();
		}
		if ($content_file_settings->enable_file_edit != 1) {
			$this->generate_message('toastr_error', 'denied', 'file edit');
			return redirect()->back();
		}
		$this->data['content_file_settings'] = $content_file_settings;

		$filter = [];
		$filter['content_id'] = $content_id;
		$filter['details_id'] = $id;
		$filter['language'] = $lang;
		$file_detail = $this->content_files_model->fetch_data($filter);
		if ($file_detail) {
			$file_detail = $file_detail[0];
		} else {
			$this->generate_message('toastr_error', 'invalid', 'file details');
			return  redirect()->back();
		}
		$this->data['file_detail'] = $file_detail;

		$validation_rules = [];
		// validation rules
		$content_fields = $this->content_validation($content_file_settings->file_form_group);
		$this->data['content_fields'] = $content_fields;
		if (!empty($content_fields['file_title']['settings']) && $content_fields['file_title']['settings']->active == 1) {
			$validation_rules['file_title'] = [
				'label' => 'title',
				'rules' => $content_fields['file_title']['validations'],
			];
		}
		if (!empty($content_fields['file_subtitle']['settings']) && $content_fields['file_subtitle']['settings']->active == 1) {
			$validation_rules['file_subtitle'] = [
				'label' => 'subtitle',
				'rules' => $content_fields['file_subtitle']['validations'],
			];
		}
		if (!empty($content_fields['file_short_description']['settings']) && $content_fields['file_short_description']['settings']->active == 1) {
			$validation_rules['short_description'] = [
				'label' => 'short description',
				'rules' => $content_fields['file_short_description']['validations'],
			];
		}
		if (!empty($content_fields['file_description']['settings']) && $content_fields['file_description']['settings']->active == 1) {
			$validation_rules['file_description'] = [
				'label' => 'description',
				'rules' => $content_fields['file_description']['validations'],
			];
		}
		if (!empty($content_fields['file_link']['settings']) && $content_fields['file_link']['settings']->active == 1) {
			$validation_rules['file_link'] = [
				'label' => 'link',
				'rules' => $content_fields['file_link']['validations'],
			];
		}
		if (!empty($content_fields['file_button_name']['settings']) && $content_fields['file_button_name']['settings']->active == 1) {
			$validation_rules['file_button_name'] = [
				'label' => 'button name',
				'rules' => $content_fields['file_button_name']['validations'],
			];
		}
		if (!empty($content_fields['file_icon']['settings']) && $content_fields['file_icon']['settings']->active == 1) {
			$validation_rules['file_icon'] = [
				'label' => 'icon',
				'rules' => $content_fields['file_icon']['validations'],
			];
		}
		$file_validation = 'trim';
		if ($content_file_settings->check_required == 1) {
			$file_validation .= '|required';
		} else {
			$file_validation .= '|permit_empty';
		}
		if ($content_file_settings->allowed_extensions) {
			$file_validation .= '|ext_in[' . $content_file_settings->form_field . ',' . $content_file_settings->allowed_extensions . ']';
		}
		if ($content_file_settings->max_width > 0 && $content_file_settings->max_height > 0) {
			$file_validation .= '|max_dims[' . $content_file_settings->form_field . ',' . $content_file_settings->max_width . ',' . $content_file_settings->max_height . ']';
		}
		if ($content_file_settings->max_size > 0) {
			$file_validation .= '|max_size[' . $content_file_settings->form_field . ',' . $content_file_settings->max_size . ']';
		}
		$validation_rules['file_upload'] = [
			'label' => 'description',
			'rules' => $file_validation,
		];

		$this->validation->setRules($validation_rules);

		// validating post request
		if ($this->request->getPost() && $this->validation->withRequest($this->request)->run()) {
			$input_data = [];
			$input_data['title'] = $this->request->getPost('file_title');
			$input_data['subtitle'] = $this->request->getPost('file_subtitle');
			$input_data['short_description'] = $this->request->getPost('file_short_description');
			$input_data['description'] = $this->request->getPost('file_description');
			$input_data['link'] = $this->request->getPost('file_link');
			$input_data['button_name'] = $this->request->getPost('file_button_name');
			$input_data['icon'] = $this->request->getPost('file_icon');
			if ($file = $this->request->getFile('file_upload')) {
				if ($file->isValid() && !$file->hasMoved()) {
					$ext = $file->getClientExtension();
					$file_name = $file->getRandomName();
					$file->move('uploads', $file_name);
					if (getimagesize('uploads/' . $file_name)) {
						$allow_resize = $content_file_settings->enable_resize;
						$width = '1024';
						$height = '768';
						if ($content_file_settings->max_width > 0) {
							$width = $content_file_settings->max_width;
						}
						if ($content_file_settings->max_height > 0) {
							$height = $content_file_settings->max_height;
						}
						$thumb_width = '100';
						$thumb_height = '150';
						if ($content_file_settings->thumb_width > 0) {
							$thumb_width = $content_file_settings->thumb_width;
						}
						if ($content_file_settings->thumb_height > 0) {
							$thumb_height = $content_file_settings->thumb_height;
						}
						$image = $this->image_lib->withFile('uploads/' . $file_name);
						if ($allow_resize == 1) {
							$image->resize($width, $height, false, 'height');
						}
						$image->save('uploads/' . $file_name);
						$this->image_lib->withFile('uploads/' . $file_name)
							->fit($thumb_width, $thumb_height, 'center')
							->save('uploads/thumb_' . $file_name);
					}
					$input_data['file'] = $file_name;
				}
			}
			$input_data['updated_by'] =  $_SESSION['user_id'];
			$this->content_file_details_model->update($id, $input_data);
			$this->generate_message('toastr_success', 'updated', 'file details');
			return redirect()->to(current_url());
		}

		// rendering view
		$this->render_page('pages/contents_file_edit');
	}
	/**
	 * Delete file
	 * @param int $id
	 * @param int $content_id
	 * @param int $content_field_settings_id
	 * @param string|null $lang
	 * @return redirect
	 */
	public function delete_file(int $id, int $content_id, int $content_field_settings_id, $lang = null)
	{
		//setting default language
		if ($lang == null) {
			$lang = $this->site_lang;
		}
		$content_language = $this->languages_model->where(['code' => $lang, 'active' => 1])->find();
		if ($content_language) {
			$content_language = $content_language[0];
		} else {
			$this->generate_message('toastr_error', 'invalid', 'language');
			return  redirect()->back();
		}
		$content_file_settings = $this->form_field_settings_model->where(['id' => $content_field_settings_id, 'active' => 1])->find();
		if ($content_file_settings) {
			$content_file_settings = $content_file_settings[0];
		} else {
			$this->generate_message('toastr_error', 'invalid', 'field settings');
			return redirect()->back();
		}
		if ($content_file_settings->enable_file_delete != 1) {
			$this->generate_message('toastr_error', 'denied', 'file delete');
			return redirect()->back();
		}
		$filter = [];
		$filter['content_id'] = $content_id;
		$filter['details_id'] = $id;
		$filter['language'] = $lang;
		$content_file_detail = $this->content_files_model->fetch_data($filter);
		if ($content_file_detail) {
			$content_file_detail = $content_file_detail[0];
		} else {
			$this->generate_message('toastr_error', 'invalid', 'file details');
			return  redirect()->back();
		}
		unlink('uploads/' . $content_file_detail->file);
		if (file_exists('uploads/thumb_' . $content_file_detail->file))
			unlink('uploads/thumb_' . $content_file_detail->file);
		$this->content_file_details_model->delete($content_file_detail->id);
		return redirect()->back();
	}
	/**
	 * Disable record
	 * @param int $id
	 * @param int $content_group
	 * @return redirect
	 */
	public function disable(int $id, int $content_group)
	{
		// getting content group
		$content_group = $this->content_groups_model->where(['id' => $content_group, 'active' => 1])->orderBy('title', 'ASC')->find();
		if ($content_group) {
			$content_group = $content_group[0];
		} else {
			$this->generate_message('toastr_error', 'invalid', 'content group');
			return  redirect()->back();
		}
		if ($content_group->enable_delete != 1) {
			$this->generate_message('toastr_error', 'denied', 'content delete');
			return  redirect()->back();
		}
		$input_data = [];
		$input_data['active'] = 2;
		$this->contents_model->update($id, $input_data);
		$this->content_translations_model->disable_by_content($id);
		$this->generate_message('toastr_success', 'deleted', 'form group');
		return redirect()->back();
	}
	/**
	 * generating content field validation
	 * @param int $form_group_id
	 * @param int|null $translation_id
	 * @return array
	 */
	private function content_validation(int $form_group_id, int $translation_id = null)
	{
		$content_validations = [];
		$form_fields = $this->form_fields_model->where('active', 1)->findAll();
		if ($form_fields) {
			foreach ($form_fields as $form_field) {
				$content_validations[$form_field->field_name]['settings'] = [];
				$content_validations[$form_field->field_name]['validations'] = [];
				$field_settings = $this->form_field_settings_model->fetch_data(['group_id' => $form_group_id]);
				if ($field_settings) {
					foreach ($field_settings as $field_setting) {
						$content_validations[$field_setting->identity]['settings'] = $field_setting;
						$field_validation = 'trim';
						if ($field_setting->check_required == 1) {
							$field_validation .= '|required';
						} else {
							$field_validation .= '|permit_empty';
						}
						if ($field_setting->check_valid_email == 1) {
							$field_validation .= '|valid_email';
						}
						if ($field_setting->match_regex) {
							$field_validation .= '|regex_match[' . $field_setting->match_regex . ']';
						}
						if ($field_setting->max_length) {
							$field_validation .= '|max_length[' . $field_setting->max_length . ']';
						}
						if ($field_setting->allowed_extensions) {
							$field_validation .= '|ext_in[' . $field_setting->form_field . ',' . $field_setting->allowed_extensions . ']';
						}
						if ($field_setting->max_width > 0 && $field_setting->max_height > 0) {
							$field_validation .= '|max_dims[' . $field_setting->form_field . ',' . $field_setting->max_width . ',' . $field_setting->max_height . ']';
						}
						if ($field_setting->max_size > 0) {
							$field_validation .= '|max_size[' . $field_setting->form_field . ',' . $field_setting->max_size . ']';
						}
						$content_validations[$field_setting->form_field_name]['validations'] = $field_validation;
					}
				}
			}
		}

		return $content_validations;
	}
}
