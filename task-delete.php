<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('location:index.php');
    die();
}

require_once __DIR__ . '/Classe/CRUD.php';
require_once __DIR__ . '/Classe/Task.php';

$id = $_POST['id'];
$projectId = $_POST['project_id'];
$crud = new CRUD;
$task = new Task($crud);
$task->remove($id);

header("location:project-show.php?id=$projectId");
