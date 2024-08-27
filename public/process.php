<?php
require_once '../vendor/autoload.php';

use App\Encryptor;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $key = $_POST['key'];
    $text = $_POST['text'] ?? '';

    // 初始化加解密工具
    $encryptor = new Encryptor($key);

    if ($action === 'encrypt') {
        $result = $encryptor->encrypt($text);
    } elseif ($action === 'decrypt') {
        $result = $encryptor->decrypt($text);
    } else {
        $result = '无效操作';
    }

    // 返回结果作为 JSON
    header('Content-Type: application/json');
    echo json_encode(['result' => $result]);
}
