<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location:statuses.php');
    die();
}

require_once __DIR__ . '/Classe/CRUD.php';
require_once __DIR__ . '/Classe/Status.php';

$id = $_POST['id'];
$crud = new CRUD;
$status = new Status($crud);

try {
    $delete = $status->remove($id);
} catch (PDOException $e) {
    $delete = false;
}

if ($delete) {
    header('location:statuses.php');
} else {
    // Échec probable : des projets ou des tâches utilisent encore ce statut.
    header('location:statuses.php?error=1');
}
