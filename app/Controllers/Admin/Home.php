<?php

namespace App\Controllers\Admin;

use App\Controllers\AdminController;

class Home extends AdminController
{

    public function index()
    {
        $this->render_page("pages/home");
    }
}
