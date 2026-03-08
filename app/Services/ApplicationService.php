<?php

namespace App\Services;

use App\Entities\Application;
use Doctrine\ORM\EntityManagerInterface;
use Flight as F;

class ApplicationService
{
    private EntityManagerInterface $em;

    public function __construct()
    {
        $this->em = F::em();
    }

    public function getPage($page, int $pageSize = 50) : mixed
    {
        $paginator = $this->em
            ->getRepository(Application::class)
            ->findForPage($page);

        return [
            'data' => iterator_to_array($paginator),
            'paginator' => [
                'currentPage' => $page,
                'totalItems' => $paginator->count(),
                'totalPages' => ceil($paginator->count() / $pageSize),
            ],
        ];
    }

    public function find(int $id) : ?Application
    {
        return $this->em
            ->getRepository(Application::class)
            ->findOneBy(['id' => $id]);
    }

    public function remove($application) : void
    {
        $this->em->remove($application);
        $this->em->flush();
    }
}
