<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location:index.php');
    die();
}

require_once __DIR__ . '/Classe/CRUD.php';
require_once __DIR__ . '/Classe/Project.php';

$crud = new CRUD;
$project = new Project($crud);
$project->update([
    'id' => $_POST['id'],
    'company_id' => $_POST['company_id'],
    'company_location_id' => $_POST['company_location_id'] ?: null,
    'primary_contact_id' => $_POST['primary_contact_id'],
    'status_id' => $_POST['status_id'],
    'title' => $_POST['title'],
    'description' => $_POST['description'] ?: null,
    'planned_start_date' => $_POST['planned_start_date'] ?: null,
    'planned_end_date' => $_POST['planned_end_date'] ?: null,
]);

$project->detachServices($_POST['id']);
if (!empty($_POST['service_ids'])) {
    $project->attachServices($_POST['id'], $_POST['service_ids']);
}

header("location:project-show.php?id={$_POST['id']}");
