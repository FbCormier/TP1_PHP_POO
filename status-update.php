<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location:statuses.php');
    die();
}

require_once __DIR__ . '/Classe/CRUD.php';
require_once __DIR__ . '/Classe/Status.php';

$crud = new CRUD;
$status = new Status($crud);
$status->update([
    'id' => $_POST['id'],
    'name' => $_POST['name'],
    'color' => $_POST['color'] ?: '#667579',
    'display_order' => $_POST['display_order'] !== '' ? (int) $_POST['display_order'] : 0,
]);

header('location:statuses.php');
