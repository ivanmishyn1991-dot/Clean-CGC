<?php

namespace App\Controllers\Dashboard;

use App\Controllers\Controller;
use App\Services\ApplicationService;
use Flight as F;

class ApplicationController extends Controller
{
    private ApplicationService $applicationService;

    public function __construct()
    {
        $this->applicationService = new ApplicationService();
        parent::__construct();
    }

    public function index() : void
    {
        $page = (int) ($_GET['page'] ?? 1);
        $this->view->display(
            'applications/index.html.twig', [
                'page' => $this->applicationService->getPage($page),
            ],
        );
    }

    public function show(int $id) : void
    {
        $this->view->display('applications/show.html.twig', [
            'application' => $this->applicationService->find($id),
        ]);
    }

    public function delete($id) : void
    {
        $application = $this->applicationService->find($id);

        if ($application) {
            $this->applicationService->remove($application);
        }

        F::json(['success' => true]);
    }
}
