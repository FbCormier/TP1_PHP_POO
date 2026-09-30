<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location:status-create.php');
    die();
}

require_once __DIR__ . '/Classe/CRUD.php';
require_once __DIR__ . '/Classe/Status.php';

if (!$_POST['name']) {
    header('location:status-create.php?error=1');
    die();
}

$crud = new CRUD;
$status = new Status($crud);
$insert = $status->create([
    'name' => $_POST['name'],
    'color' => $_POST['color'] ?: '#667579',
    'display_order' => $_POST['display_order'] !== '' ? (int) $_POST['display_order'] : 0,
]);

if ($insert) {
    header('location:statuses.php?created=1');
} else {
    header('location:status-create.php?error=1');
}
