<?php
if (!isset($_GET['id']) or $_GET['id'] == null) {
    header('location:index.php');
    die();
}
$id = $_GET['id'];

require_once __DIR__ . '/Classe/CRUD.php';
require_once __DIR__ . '/Classe/Task.php';

$crud = new CRUD;
$task = new Task($crud);
$taskData = $task->find($id);

if (!$taskData) {
    header('location:index.php');
    die();
}

$projectData = $crud->selectId('project', $taskData['project_id']);
$statuses = $crud->select('status', 'display_order');

extract($taskData);
$pageTitle = 'Modifier ' . $title;
require __DIR__ . '/includes/header.php';
?>

<div class="app-layout">
    <?php require __DIR__ . '/includes/sidebar.php'; ?>

    <main class="main-content" id="main-content">
        <div class="page-body">

            <div class="page-heading">
                <div>
                    <h1>Modifier la tâche</h1>
                    <p>Projet : <strong><?= htmlspecialchars($projectData['title']) ?></strong></p>
                </div>
                <a href="project-show.php?id=<?= $project_id ?>" class="button button--secondary">Retour à la fiche</a>
            </div>

            <form method="post" action="task-update.php">
                <section class="main-container">
                    <div class="card__header">
                        <div>
                            <h2 class="card__title">Informations de la tâche</h2>
                        </div>
                    </div>
                    <div class="form-grid">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <input type="hidden" name="project_id" value="<?= $project_id ?>">
                        <div>
                            <div class="form-field">
                                <label class="form-label" for="title">Titre de la tâche <span style="color:var(--error-text-color)">*</span></label>
                                <input id="title" name="title" class="form-input" required value="<?= htmlspecialchars($title) ?>">
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="description">Description</label>
                                <textarea id="description" name="description" class="form-textarea"><?= htmlspecialchars($description ?? '') ?></textarea>
                            </div>
                        </div>
                        <div>
                            <div class="form-field">
                                <label class="form-label" for="status_id">Statut <span style="color:var(--error-text-color)">*</span></label>
                                <select id="status_id" name="status_id" class="form-select" required>
                                    <?php foreach ($statuses as $status): ?>
                                        <option value="<?= $status['id'] ?>" <?= $status['id'] == $status_id ? 'selected' : '' ?>><?= htmlspecialchars($status['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="planned_start_date">Début prévu</label>
                                <input type="date" id="planned_start_date" name="planned_start_date" class="form-input" value="<?= htmlspecialchars($planned_start_date ?? '') ?>">
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="planned_end_date">Fin prévue</label>
                                <input type="date" id="planned_end_date" name="planned_end_date" class="form-input" value="<?= htmlspecialchars($planned_end_date ?? '') ?>">
                            </div>
                        </div>
                    </div>
                </section>

                <div class="form-field">
                    <button type="submit" class="button button--primary">Enregistrer les modifications</button>
                </div>
            </form>

        </div>
    </main>
</div>

</body>

</html>