<?php
namespace App;

class KeyGenerator
{
    public static function generateRandomKey()
    {
        return bin2hex(random_bytes(32)); // 32字节 = 256位
    }
}
