<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location:project-create.php');
    die();
}

require_once __DIR__ . '/Classe/CRUD.php';
require_once __DIR__ . '/Classe/Project.php';

$crud = new CRUD;
$project = new Project($crud);

if (!$_POST['title'] || !$_POST['company_id'] || !$_POST['primary_contact_id'] || !$_POST['status_id']) {
    header('location:project-create.php?error=1');
    die();
}

$insert = $project->create([
    'company_id' => $_POST['company_id'],
    'company_location_id' => $_POST['company_location_id'] ?: null,
    'primary_contact_id' => $_POST['primary_contact_id'],
    'status_id' => $_POST['status_id'],
    'title' => $_POST['title'],
    'description' => $_POST['description'] ?: null,
    'planned_start_date' => $_POST['planned_start_date'] ?: null,
    'planned_end_date' => $_POST['planned_end_date'] ?: null,
]);

if ($insert && !empty($_POST['service_ids'])) {
    $project->attachServices($insert, $_POST['service_ids']);
}

if ($insert) {
    header("location:index.php?created=1");
} else {
    header("location:project-create.php?error=1");
}
