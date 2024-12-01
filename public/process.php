<?php
require_once '../vendor/autoload.php';

use App\Encryptor;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $key = $_POST['key'];
    $text = $_POST['text'] ?? '';
    $encryptor = new Encryptor($key);

    if ($action === 'encrypt') {
        $result = $encryptor->encrypt($text);
    } elseif ($action === 'decrypt') {
        $result = $encryptor->decrypt($text);
    } else {
        $result = '无效操作';
    }
    header('Content-Type: application/json');
    echo json_encode(['result' => $result]);
}
