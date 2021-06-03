<?php

namespace App\Controllers;

/**
 * Class AdminController
 *
 * AdminController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends AdminController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;
//loading library
use App\Libraries\Common_lib;

class AdminController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend AdminController.
	 *
	 * @var array
	 */
	protected $helpers = ['form', 'url'];
	protected $data = [];
	protected $request;
	protected $session;
	protected $validation;
	protected $db;
	protected $site_title;
	protected $site_lang;

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		// site title
		$this->site_title = getenv('cms.site.title');
		$this->data['site_title'] = $this->site_title;
		// site language
		$this->site_lang = getenv('cms.default.lang');
		$this->data['site_lang'] = $this->site_lang;
		// active menu item flag
		$this->data['active_menu'] = '';
		// display content title & subtitle
		$this->data['content_title'] = '';
		$this->data['content_subtitle'] = '';
		// loading service http request
		$this->request = \Config\Services::request();
		// loading session service
		$this->session = \Config\Services::session();
		// passing session object
		$this->data['session'] = $this->session;
		// loading validation service
		$this->validation = \Config\Services::validation();
		// passing validation object
		$this->data['validation'] = $this->validation;
		// loading db connection
		$this->db = \Config\Database::connect();
		// loading common library
		$this->common_lib = new Common_lib();
		// getting alert message
		$this->data['alert_msg'] = $this->get_alert_msg();
		// loading ionAuth library
		$this->ionAuth    = new \IonAuth\Libraries\IonAuth();
		$this->data['user'] = '';
		if ($this->ionAuth->loggedIn()) {
			$user   = $user = $this->ionAuth->user()->row();
			$this->data['user'] = $user;
		}
	}

	/**
	 * generate message 
	 * eg: added, updated, deleted etc.
	 * @param string $msg_type
	 * @param string|null $action
	 * @param string|null $label
	 * @param string|null $msg
	 * @param bool $keep_flash_data
	 * return void
	 */
	protected function generate_message($msg_type, $action = NULL, $label = NULL, $msg = NULL, $keep_flash_data = false)
	{
		if ($action != NULL) {
			$action = strtolower($action);
		}
		if ($action == 'added') {
			$action_msg = 'added successfully';
		} else if ($action == 'created') {
			$action_msg = 'created successfully';
		} else if ($action == 'updated') {
			$action_msg = 'updated successfully';
		} else if ($action == 'saved') {
			$action_msg = 'saved successfully';
		} else if ($action == 'deleted') {
			$action_msg = 'deleted successfully';
		} else if ($action == 'activated') {
			$action_msg = 'activated successfully';
		} else if ($action == 'deactivated') {
			$action_msg = 'deactivated successfully';
		} else if ($action == 'enabled') {
			$action_msg = 'enabled successfully';
		} else if ($action == 'disabled') {
			$action_msg = 'disabled successfully';
		} else if ($action == 'exists') {
			$action_msg = 'already exists';
		} else if ($action == 'invalid') {
			$action_msg = 'invalid';
		} else if ($action == 'unknown') {
			$action_msg = 'Something went wrong, please try again';
		}
		if ($msg) {
			$action_msg = $msg;
		}
		if ($label) {
			$action_msg = $label . ' ' . $action_msg;
		}
		$action_msg = ucfirst($action_msg);
		if ($keep_flash_data) {
			$this->session->keepFlashdata($msg_type, $action_msg);
		} else {
			$this->session->setFlashdata($msg_type, $action_msg);
		}
	}
	/**
	 * setting boostrap alert message
	 */
	function get_alert_msg()
	{
		$alert_msg = '';
		if ($this->session->getFlashdata('success')) {
			$alert_msg = '<div class="alert alert-success alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' . $this->session->getFlashdata('success') . '</div>';
		} else if ($this->session->getFlashdata('error')) {
			$alert_msg = '<div class="alert alert-danger alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' . $this->session->getFlashdata('error') . '</div>';
		} else if ($this->session->getFlashdata('warning')) {
			$alert_msg = '<div class="alert alert-warning alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' . $this->session->getFlashdata('warning') . '</div>';
		} else if ($this->session->getFlashdata('info')) {
			$alert_msg = '<div class="alert alert-info alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' . $this->session->getFlashdata('info') . '</div>';
		}
		return $alert_msg;
	}

	/**
	 * Rendering admin view page
	 * @param $page
	 * @param array|null $data
	 * @param bool $return_view
	 * @return void|string
	 */
	protected function render_page(string $page, bool $return_view = false, $data = null)
	{
		$data = $data ?: $this->data;

		$view_page = view('admin/' . $page, $data);

		if ($return_view) {
			return $view_page;
		} else {
			echo $view_page;
		}
	}
}
