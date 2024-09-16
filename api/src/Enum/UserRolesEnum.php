<?php

namespace App\Enum;

enum UserRolesEnum: string
{
    use ValidateEnumTrait;

    case ROLE_USER  = 'ROLE_USER';
    case ROLE_ADMIN = 'ROLE_ADMIN';
}
