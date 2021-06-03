<?php

namespace App\Controllers\Admin;

use App\Controllers\AdminController;

class Auth extends AdminController
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
	 * function to do login proccess
	 */
	public function login()
	{
		if ($this->ionAuth->loggedIn()) {
			if ($this->ionAuth->isAdmin()) {
				// redirect them to the dashboard page
				return redirect()->route('admin/dashboard');
			}
		}
		// active menu item flag
		$this->data['active_menu'] = 'admin_login';
		// validation rules
		$this->validation->setRules([
			'identity' => [
				'label' => 'email',
				'rules' => 'trim|required|valid_email|max_length[50]',
			],
			'password' => [
				'label' => 'password',
				'rules' => 'trim|required|max_length[20]',
			]
		]);
		if ($this->request->getPost() && $this->validation->withRequest($this->request)->run()) {
			// check to see if the user is logging in
			// check for "remember me"
			$remember = (bool)$this->request->getVar('remember');

			if ($this->ionAuth->login($this->request->getVar('identity'), $this->request->getVar('password'), $remember)) {
				//if the login is successful
				//redirect them back to the home page
				$this->generate_message('success', NULL, NULL, $this->ionAuth->messages());
				return redirect()->route('admin/dashboard')->withCookies();
			} else {
				// if the login was un-successful
				// redirect them back to the login page
				$this->generate_message('error', NULL, NULL, $this->ionAuth->errors($this->validationListTemplate));
				// use redirects instead of loading views for compatibility with MY_Controller libraries
				return redirect()->back()->withInput();
			}
		}
		$this->render_page('login');
	}

	/**
	 * Log the user out
	 *
	 * @return \CodeIgniter\HTTP\RedirectResponse
	 */
	public function logout()
	{
		// log the user out
		$this->ionAuth->logout();

		// redirect them to the login page
		$this->generate_message('success', NULL, NULL, $this->ionAuth->messages());
		return redirect()->route('admin/login')->withCookies();
	}
}
