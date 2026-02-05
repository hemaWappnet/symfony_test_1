<?php

namespace App\DTO;

class CommentDTO
{
    public function __construct(
        public ?int $id = null,
        public ?string $content = null,
        public ?int $postId = null,
        public ?string $createdAt = null
    ) {}
}