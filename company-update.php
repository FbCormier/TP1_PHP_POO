<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location:companies.php');
    die();
}

require_once __DIR__ . '/Classe/CRUD.php';
require_once __DIR__ . '/Classe/Company.php';

$crud = new CRUD;
$company = new Company($crud);
$company->update([
    'id' => $_POST['id'],
    'name' => $_POST['name'],
    'website' => $_POST['website'] ?: null,
]);

header("location:company-show.php?id={$_POST['id']}");
