<?php

declare(strict_types=1);

namespace App\Models;

class Article
{
    private string $title;
    private string $description;
    private string $image;
    private string $created;
    private ?string $modified;
    private ?int $id;

    public function __construct(
        string $title,
        string $description,
        string $image,
        string $created,
        ?string $modified,
        ?int $id
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->image = $image;
        $this->created = $created;
        $this->modified = $modified;
        $this->id = $id;
    }
    
    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getCreated(): string
    {
        return $this->created;
    }

    public function getModified(): ?string
    {
        return $this->modified ?? null;
    }

    public function getId(): ?int
    {
        return $this->id ?? null;
    }
}