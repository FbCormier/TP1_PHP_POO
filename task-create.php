<?php
if (!isset($_GET['project_id']) or $_GET['project_id'] == null) {
    header('location:index.php');
    die();
}
$projectId = $_GET['project_id'];

require_once __DIR__ . '/Classe/CRUD.php';
require_once __DIR__ . '/Classe/Project.php';

$crud = new CRUD;
$project = new Project($crud);
$projectData = $project->find($projectId);

if (!$projectData) {
    header('location:index.php');
    die();
}

$statuses = $crud->select('status', 'display_order');

$pageTitle = 'Nouvelle tâche';
require __DIR__ . '/includes/header.php';
?>

<div class="app-layout">
    <?php require __DIR__ . '/includes/sidebar.php'; ?>

    <main class="main-content" id="main-content">
        <div class="page-body">

            <div class="page-heading">
                <div>
                    <h1>Ajouter une tâche</h1>
                    <p>Projet : <strong><?= htmlspecialchars($projectData['title']) ?></strong></p>
                </div>
                <a href="project-show.php?id=<?= $projectId ?>" class="button button--secondary">Retour à la fiche</a>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert--error" style="margin-bottom: var(--space-6)">
                    <p class="alert__title">Impossible d'enregistrer la tâche</p>
                    <p class="alert__text">Le titre et le statut sont requis.</p>
                </div>
            <?php endif; ?>

            <form method="post" action="task-store.php">
                <section class="main-container">
                    <div class="card__header">
                        <div>
                            <h2 class="card__title">Informations de la tâche</h2>
                        </div>
                    </div>
                    <div class="form-grid">
                        <input type="hidden" name="project_id" value="<?= $projectId ?>">
                        <div>
                            <div class="form-field">
                                <label class="form-label" for="title">Titre de la tâche <span style="color:var(--error-text-color)">*</span></label>
                                <input id="title" name="title" class="form-input" required placeholder="Préparer la maquette">
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="description">Description</label>
                                <textarea id="description" name="description" class="form-textarea" placeholder="Détails de la tâche"></textarea>
                            </div>
                        </div>
                        <div>
                            <div class="form-field">
                                <label class="form-label" for="status_id">Statut <span style="color:var(--error-text-color)">*</span></label>
                                <select id="status_id" name="status_id" class="form-select" required>
                                    <option value="">-- Choisir un statut --</option>
                                    <?php foreach ($statuses as $status): ?>
                                        <option value="<?= $status['id'] ?>"><?= htmlspecialchars($status['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="planned_start_date">Début prévu</label>
                                <input type="date" id="planned_start_date" name="planned_start_date" class="form-input">
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="planned_end_date">Fin prévue</label>
                                <input type="date" id="planned_end_date" name="planned_end_date" class="form-input">
                            </div>
                        </div>
                    </div>
                </section>

                <div class="form-field">
                    <button type="submit" class="button button--primary">Enregistrer la tâche</button>
                </div>
            </form>

        </div>
    </main>
</div>

</body>

</html>