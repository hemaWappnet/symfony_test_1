<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

class CreatePostRequest
{
    #[Assert\NotBlank(message: 'Title is required')]
    #[Assert\Length(min: 3, max: 255, minMessage: 'Title must be at least 3 characters long')]
    public ?string $title = null;

    #[Assert\NotBlank(message: 'Content is required')]
    #[Assert\Length(min: 10, minMessage: 'Content must be at least 10 characters long')]
    public ?string $content = null;
}