<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private bool $done = false;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $assignee = null;

    public function getId(): ?int { return $this->id; }
    public function getTitle(): ?string { return $this->title; }
    public function isDone(): bool { return $this->done; }
    public function getAssignee(): ?User { return $this->assignee; }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function setDone(bool $done): static
    {
        $this->done = $done;

        return $this;
    }


    public function setAssignee(?User $assignee): static
    {
        $this->assignee = $assignee;

        return $this;
    }
}
