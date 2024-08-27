<?php
namespace App;

class Encryptor
{
    private $key;
    private $iv;

    public function __construct($key)
    {
        $this->key = $key;
        $this->iv = substr(hash('sha256', $key), 0, 16); // AES-256-CBC需要16字节IV
    }

    public function encrypt($data)
    {
        return base64_encode(openssl_encrypt($data, 'aes-256-cbc', $this->key, 0, $this->iv));
    }

    public function decrypt($data)
    {
        return openssl_decrypt(base64_decode($data), 'aes-256-cbc', $this->key, 0, $this->iv);
    }
}
