<?php

namespace App\Controllers\Dashboard;

use App\Controllers\Controller;
use App\Services\AuthService;
use Flight as F;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
        parent::__construct();
    }

    public function enter() : void
    {
        $this->view->display('login.twig.html');
    }

    public function login(): void
    {
        $data = F::request()->data->getData();
        $user = $this->authService->login($data['username'], $data['password']);

        if ($user) {
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['user_email'] = $user->getEmail();
            F::redirect('/admin/applications');
        } else {
            F::json(['success' => false, 'message' => 'Login failed']);
        }
    }
}
