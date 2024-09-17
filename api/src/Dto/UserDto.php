<?php

namespace App\Dto;

use App\Entity\User;
use App\Enum\UserRolesEnum;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[Assert\GroupSequence(['UserDto','register', 'create', 'edit'])]
#[UniqueEntity(
    fields: 'email',
    message: 'This email is already taken.',
    entityClass: User::class,
    identifierFieldNames: ['id' => 'id'],
    groups: ['UserDto', 'register', 'create']
)]
readonly class UserDto
{
    public function __construct(
        #[Assert\NotBlank(message: 'Email is required', groups: ['register', 'create'])]
        #[Assert\Callback([UserRepository::class, 'findByEmail'])]
        public ?string $email,

        #[Assert\NotBlank(message: 'Roles should be defined', groups: ['create', 'edit'])]
        #[Assert\Type('array', groups: ['create', 'edit'])]
        #[Assert\All(
            new Assert\Callback([UserRolesEnum::class, 'validate']),
            groups: ['create', 'edit']
        )]
        #[Assert\Blank(message: 'Roles can`t be provided on registration' , groups: ['register'])]
        public ?array  $roles,

        #[Assert\NotBlank(message: 'Password is required', groups: ['register'])]
        public ?string $password,

        /** @ToDo figure out if I can bind route parameter here. It will allow to validate email doubles on update */
        public ?int     $id = null,

    ){
    }
}