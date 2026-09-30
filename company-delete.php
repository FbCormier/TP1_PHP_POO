<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("location:companies.php");
    die();
}

require_once __DIR__ . '/Classe/CRUD.php';
require_once __DIR__ . '/Classe/Company.php';

$id = $_POST['id'];
$crud = new CRUD;
$company = new Company($crud);
$delete = $company->remove($id);

if ($delete) {
    header('location:companies.php');
} else {
    // Échec probable : des contacts, emplacements ou projets dépendent encore de cette entreprise.
    header("location:company-show.php?id=$id&error=1");
}
