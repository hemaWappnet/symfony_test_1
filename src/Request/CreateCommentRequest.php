<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

class CreateCommentRequest
{
    #[Assert\NotBlank(message: 'Content is required')]
    #[Assert\Length(min: 5, minMessage: 'Comment must be at least 5 characters long')]
    public ?string $content = null;
}