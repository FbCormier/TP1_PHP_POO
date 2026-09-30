<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location:index.php');
    die();
}

require_once __DIR__ . '/Classe/CRUD.php';
require_once __DIR__ . '/Classe/Task.php';

if (!$_POST['title'] || !$_POST['project_id'] || !$_POST['status_id']) {
    header("location:task-create.php?project_id={$_POST['project_id']}&error=1");
    die();
}

$crud = new CRUD;
$task = new Task($crud);

$insert = $task->create([
    'project_id' => $_POST['project_id'],
    'status_id' => $_POST['status_id'],
    'title' => $_POST['title'],
    'description' => $_POST['description'] ?: null,
    'planned_start_date' => $_POST['planned_start_date'] ?: null,
    'planned_end_date' => $_POST['planned_end_date'] ?: null,
]);

if ($insert) {
    header("location:project-show.php?id={$_POST['project_id']}&created=1");
} else {
    header("location:task-create.php?project_id={$_POST['project_id']}&error=1");
}
