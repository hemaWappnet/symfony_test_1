<?php

namespace App\DTO;

class PostDTO
{
    public function __construct(
        public ?int $id = null,
        public ?string $title = null,
        public ?string $content = null,
        public ?string $createdAt = null,
        public ?string $updatedAt = null,
        public array $comments = []
    ) {}
}