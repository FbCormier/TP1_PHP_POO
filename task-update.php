<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location:index.php');
    die();
}

require_once __DIR__ . '/Classe/CRUD.php';
require_once __DIR__ . '/Classe/Task.php';

$crud = new CRUD;
$task = new Task($crud);
$task->update([
    'id' => $_POST['id'],
    'status_id' => $_POST['status_id'],
    'title' => $_POST['title'],
    'description' => $_POST['description'] ?: null,
    'planned_start_date' => $_POST['planned_start_date'] ?: null,
    'planned_end_date' => $_POST['planned_end_date'] ?: null,
]);

header("location:project-show.php?id={$_POST['project_id']}");
