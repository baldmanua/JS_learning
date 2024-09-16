<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

readonly class PostDto
{

    public function __construct(
        #[Assert\NotBlank(message: 'Title can`t be blank')]
        public ?string $title,

        #[Assert\NotBlank(message: 'Description can`t be blank')]
        public ?string $description,
    ){}
}