<?php

namespace App\Controllers\Dashboard;

use App\Controllers\Controller;

class PageController extends Controller
{
    public function index() : void
    {

    }

    public function create() : void
    {
        $this->view->display('pages/create.html.twig');
    }
}