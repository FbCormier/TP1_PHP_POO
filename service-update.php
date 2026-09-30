<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location:services.php');
    die();
}

require_once __DIR__ . '/Classe/CRUD.php';
require_once __DIR__ . '/Classe/Service.php';

$crud = new CRUD;
$service = new Service($crud);
$service->update([
    'id' => $_POST['id'],
    'name' => $_POST['name'],
    'description' => $_POST['description'] ?: null,
]);

header('location:services.php');
