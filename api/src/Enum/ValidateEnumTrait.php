<?php

namespace App\Enum;

use Symfony\Component\Validator\Exception\ValidatorException;

trait ValidateEnumTrait
{
    public static function validate(string $item): bool
    {
        if (!self::tryFrom($item) instanceof self) {
            throw new ValidatorException($item . ' is not a valid backing value for enum ' . self::class);
        }

        return true;
    }
}