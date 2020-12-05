<?php

declare(strict_types=1);

use App\model\UserModel;

function generateToken(): string
{
    return md5(bin2hex(openssl_random_pseudo_bytes(128)));
}

function hashPassword(string $password): string
{
    return password_hash($password, PASSWORD_DEFAULT, ['salt' => '$W<_6,Vt^/%_:(G]{:X7w)hcS+,/eB']);
}

function getVal(UserModel $obj, string $field, string $getter): ?string
{
    if ($obj instanceof UserModel) {
        return strval($obj->$getter());
    }
    foreach ($obj as $key => $value) {
        if ($key == $field) {
            return strval($value);
        }
    }

    return null;
}

function redirect(string $uri): void
{
    header("Location: $uri");
}
