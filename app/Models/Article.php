<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;

class Article
{
    private string $title;
    private string $description;
    private string $image;
    private Carbon $created;
    private ?Carbon $modified;
    private ?int $id;

    public function __construct(
        string $title,
        string $description,
        string $image,
        string $created,
        ?string $modified = null,
        ?int $id = null
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->image = $image;
        $this->created = new Carbon($created);
        $this->modified = $modified ? new Carbon($modified) : null;
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

    public function getCreated(): Carbon
    {
        return $this->created;
    }

    public function getModified(): ?Carbon
    {
        return $this->modified ?? null;
    }

    public function getId(): ?int
    {
        return $this->id ?? null;
    }
}