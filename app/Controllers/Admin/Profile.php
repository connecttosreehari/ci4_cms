<?php

namespace App\Controllers\Admin;

use App\Controllers\AdminController;

class Profile extends AdminController
{
	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->ionAuth    = new \IonAuth\Libraries\IonAuth();
		$this->validation = \Config\Services::validation();
		$this->configIonAuth = config('IonAuth');
		if (!empty($this->configIonAuth->templates['errors']['list'])) {
			$this->validationListTemplate = $this->configIonAuth->templates['errors']['list'];
		}
	}
	/**
	 * loading profile
	 */
	public function index()
	{
		// display title
		$this->data['content_title'] = 'Profile';
		$this->data['content_subtitle'] = 'Edit';
		// validation rules
		$this->validation->setRules([
			'first_name' => [
				'label' => 'first name',
				'rules' => 'trim|required|max_length[50]',
			],
			'last_name' => [
				'label' => 'last name',
				'rules' => 'trim|required|max_length[50]',
			],
			'email' => [
				'label' => 'email',
				'rules' => 'trim|required|valid_email|max_length[100]',
			],
			'phone' => [
				'label' => 'phone',
				'rules' => 'trim|required',
			],
			'company' => [
				'label' => 'company',
				'rules' => 'trim|required',
			],
		]);
		// checking requested method is post
		if ($this->request->getPost() && $this->validation->withRequest($this->request)->run()) {
			$input_data = [
				'first_name' => $this->request->getPost('first_name'),
				'last_name'  => $this->request->getPost('last_name'),
				'email'    => $this->request->getPost('email'),
				'company'    => $this->request->getPost('company'),
				'phone'      => $this->request->getPost('phone'),
			];


			// check to see if we are updating the user
			if ($this->ionAuth->update($_SESSION['user_id'], $input_data)) {
				$this->generate_message('success', NULL, NULL,  $this->ionAuth->messages());
				return redirect()->route('profile');
			} else {
				$this->generate_message('error', NULL, NULL,  $this->ionAuth->errors($this->validationListTemplate));
			}
		}

		// rendering view
		$this->render_page('pages/profile');
	}
	/**
	 * change password
	 */
	public function change_password()
	{
		// display title
		$this->data['content_title'] = 'Profile';
		$this->data['content_subtitle'] = 'Change Password';
		// active menu item flag
		$this->data['active_menu'] = 'change_password';

		$identity = $this->session->get('identity');
		$user = $this->ionAuth->user()->row();
		$min_password_length = $this->configIonAuth->minPasswordLength;

		// validation rules
		$this->validation->setRules([
			'old_password' => [
				'label' => 'old password',
				'rules' => 'trim|required|max_length[50]',
			],
			'new_password' => [
				'label' => 'new password',
				'rules' => 'trim|required|min_length[' . $min_password_length . ']|max_length[50]',
			],
			'confirm_password' => [
				'label' => 'new password',
				'rules' => 'trim|required|min_length[' . $min_password_length . ']|max_length[50]',
			],
		]);
		// checking requested method is post
		if ($this->request->getMethod() == 'post' && $this->validation->withRequest($this->request)->run()) {
			$change = $this->ionAuth->changePassword($identity, $this->request->getPost('old_password'), $this->request->getPost('new_password'));
			if ($change) {
				$this->generate_message('success', NULL, NULL,  $this->ionAuth->messages());
				return redirect()->to(current_url());
			} else {
				$this->generate_message('error', NULL, NULL,  $this->ionAuth->errors($this->validationListTemplate));
				return redirect()->back();
			}
		}
		// rendering view
		$this->render_page('pages/change_password');
	}
}
