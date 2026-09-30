<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location:companies.php');
    die();
}

require_once __DIR__ . '/Classe/CRUD.php';
require_once __DIR__ . '/Classe/Contact.php';

if (!$_POST['first_name'] || !$_POST['last_name']) {
    header("location:contact-edit.php?id={$_POST['id']}&error=1");
    die();
}

$crud = new CRUD;
$contact = new Contact($crud);
$contact->update([
    'id' => $_POST['id'],
    'company_location_id' => $_POST['company_location_id'] ?: null,
    'first_name' => $_POST['first_name'],
    'last_name' => $_POST['last_name'],
    'job_title' => $_POST['job_title'] ?: null,
    'phone' => $_POST['phone'] ?: null,
    'email' => $_POST['email'] ?: null,
]);

header("location:company-show.php?id={$_POST['company_id']}");
