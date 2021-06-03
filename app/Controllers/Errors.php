<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Errors extends BaseController
{
	/**
	 * display 404 page no found
	 */
	public function show_404()
	{
		echo view('common/errors/error_404');
		exit();
	}

	/**
	 * display 403 forbidden
	 */
	public function show_403()
	{
		echo view('common/errors/error_403');
		exit();
	}
}
