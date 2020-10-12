<?php


function generateToken () {
    return md5(bin2hex(openssl_random_pseudo_bytes(128)));
}