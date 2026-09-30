<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location:service-create.php');
    die();
}

require_once __DIR__ . '/Classe/CRUD.php';
require_once __DIR__ . '/Classe/Service.php';

if (!$_POST['name']) {
    header('location:service-create.php?error=1');
    die();
}

$crud = new CRUD;
$service = new Service($crud);
$insert = $service->create([
    'name' => $_POST['name'],
    'description' => $_POST['description'] ?: null,
]);

if ($insert) {
    header('location:services.php?created=1');
} else {
    header('location:service-create.php?error=1');
}
