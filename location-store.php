<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location:companies.php');
    die();
}

require_once __DIR__ . '/Classe/CRUD.php';
require_once __DIR__ . '/Classe/CompanyLocation.php';

if (!$_POST['company_id'] || !$_POST['name']) {
    header("location:location-create.php?company_id={$_POST['company_id']}&error=1");
    die();
}

$crud = new CRUD;
$location = new CompanyLocation($crud);
$location->create([
    'company_id' => $_POST['company_id'],
    'name' => $_POST['name'],
    'address' => $_POST['address'] ?: null,
    'unit' => $_POST['unit'] ?: null,
    'postal_code' => $_POST['postal_code'] ?: null,
    'country' => $_POST['country'] ?: null,
    'region' => $_POST['region'] ?: null,
    'city' => $_POST['city'] ?: null,
    'phone' => $_POST['phone'] ?: null,
    'email' => $_POST['email'] ?: null,
]);

header("location:company-show.php?id={$_POST['company_id']}");
