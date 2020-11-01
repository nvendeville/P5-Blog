<?php


function generateToken()
{
    return md5(bin2hex(openssl_random_pseudo_bytes(128)));
}

function hashPassword($password)
{
    return password_hash($password, PASSWORD_DEFAULT, ['salt' => '$W<_6,Vt^/%_:(G]{:X7w)hcS+,/eB']);
}

function getVal($obj, $field, $getter)
{
    if ($obj instanceof \App\model\UserModel) {
        return $obj->$getter();
    }
    foreach ($obj as $key => $value) {
        if ($key == $field) {
            return $value;
        }
    }
}