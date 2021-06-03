<?php

namespace App\Controllers\Admin;

use App\Controllers\AdminController;
//loading model
use App\Models\SettingsModel;

class Settings extends AdminController
{
	/**
	 * @var $settings_model
	 */
	protected $settings_model;
	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->settings_model = new SettingsModel();
	}
	/**
	 * loading cms settings
	 */
	public function index()
	{
		// display title
		$this->data['content_title'] = 'Profile';
		$this->data['content_subtitle'] = 'Edit';
		$settings=$this->settings_model->where('id',1)->find();
		if($settings){
			$settings=$settings[0];
		}
		$this->data['settings']=$settings;
		// validation rules
		$this->validation->setRules([
			'contact_email' => [
				'label' => 'contact email',
				'rules' => 'trim|required|valid_email|max_length[100]',
			],
			'contact_phone' => [
				'label' => 'Call Us',
				'rules' => 'trim|max_length[50]',
			],
		]);
		// checking requested method is post
		if ($this->request->getPost() && $this->validation->withRequest($this->request)->run()) {
			$input_data = [];
			$input_data['contact_email'] = $this->request->getPost('contact_email');
			$input_data['contact_phone'] = $this->request->getPost('contact_phone');
			$this->settings_model->update(1, $input_data);
			$this->generate_message('toastr_success', 'updated', 'settings');
			return redirect()->to(current_url());
		}
		// rendering view
		$this->render_page('pages/settings');
	}
}
