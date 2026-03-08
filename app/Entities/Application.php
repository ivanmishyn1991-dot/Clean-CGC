<?php

namespace App\Entities;

use App\Repositories\ApplicationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
#[ORM\Table(name: 'applications')]
#[ORM\HasLifecycleCallbacks]
class Application
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 80)]
    private string $name;

    #[ORM\Column(type: 'string', length: 80)]
    private ?string $email = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(type: 'string', length: 40, nullable: true)]
    private ?string $city = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $message = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $images;

    #[ORM\Column(type: 'integer', length: 50, options: ['default' => 1])]
    private int $status = 1;

    #[ORM\Column(name: 'contact_consent', type: 'boolean', options: ['default' => true])]
    private bool $contactConsent = true;

    #[ORM\Column(name: 'created_at', type: 'integer')]
    private int $createdAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Application
    {
        $this->name = trim($name);
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): Application
    {
        $this->email = trim($email);
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): Application
    {
        $this->phone = trim($phone);
        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): Application
    {
        $this->city = trim($city);
        return $this;
    }

    public function getImages(): ?array
    {
        return $this->images;
    }

    public function setImage(string $image): Application
    {
        $this->images[] = trim($image);
        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): Application
    {
        $this->message = $message;
        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): Application
    {
        $this->status = $status;
        return $this;
    }

    public function getCreatedAt(): int
    {
        return $this->createdAt;
    }

    public function isContactConsent(): bool
    {
        return $this->contactConsent;
    }

    public function setContactConsent(bool $contactConsent): Application
    {
        $this->contactConsent = $contactConsent;
        return $this;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): void
    {
        $this->createdAt = time();
    }
}
