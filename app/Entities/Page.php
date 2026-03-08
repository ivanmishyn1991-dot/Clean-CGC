<?php

namespace App\Entities;

use App\Repositories\PageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PageRepository::class)]
#[ORM\Table(name: 'pages')]
class Page
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 80)]
    private string $route;

    #[ORM\Column(type: 'string', length: 80)]
    private string $title;

    #[ORM\Column(type: 'text')]
    private ?string $content;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Page
    {
        $this->id = $id;
        return $this;
    }

    public function getRoute(): string
    {
        return $this->route;
    }

    public function setRoute(string $route): Page
    {
        $this->route = $route;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Page
    {
        $this->title = $title;
        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): Page
    {
        $this->content = $content;
        return $this;
    }
}
