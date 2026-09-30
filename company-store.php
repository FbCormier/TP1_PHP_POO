<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location:company-create.php');
    die();
}

require_once __DIR__ . '/Classe/CRUD.php';
require_once __DIR__ . '/Classe/Company.php';

if (!$_POST['name']) {
    header('location:company-create.php?error=1');
    die();
}

$crud = new CRUD;
$company = new Company($crud);
$insert = $company->create([
    'name' => $_POST['name'],
    'website' => $_POST['website'] ?: null,
]);

if ($insert) {
    header("location:company-show.php?id=$insert&created=1");
} else {
    header("location:company-create.php?error=1");
}
