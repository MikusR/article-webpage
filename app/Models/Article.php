<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;

class Article
{
    private string $title;
    private string $text;
    private string $image;
    private Carbon $created;
    private ?Carbon $modified;
    private ?int $id;

    public function __construct(
        string $title,
        string $text,
        string $image,
        ?string $created = null,
        ?string $modified = null,
        ?int $id = null
    ) {
        $this->title = $title;
        $this->text = $text;
        $this->image = $image;
        $this->created = $created == null ? Carbon::now() : new Carbon($created);
        $this->modified = $modified ? new Carbon($modified) : null;
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getText(): string
    {
        return $this->text;
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