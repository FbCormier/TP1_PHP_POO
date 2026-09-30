<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location:services.php');
    die();
}

require_once __DIR__ . '/Classe/CRUD.php';
require_once __DIR__ . '/Classe/Service.php';

$id = $_POST['id'];
$crud = new CRUD;
$service = new Service($crud);

try {
    $delete = $service->remove($id);
} catch (PDOException $e) {
    $delete = false;
}

if ($delete) {
    header('location:services.php');
} else {
    // Échec probable : ce service est encore rattaché à des projets.
    header('location:services.php?error=1');
}
