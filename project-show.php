<?php
if (!isset($_GET['id']) or $_GET['id'] == null) {
    header('location:index.php');
    die();
}
$id = $_GET['id'];

require_once __DIR__ . '/Classe/CRUD.php';
require_once __DIR__ . '/Classe/Project.php';
require_once __DIR__ . '/Classe/Task.php';

$crud = new CRUD;
$project = new Project($crud);
$task = new Task($crud);
$projectData = $project->find($id);

if (!$projectData) {
    header('location:index.php');
    die();
}

$company = $crud->selectId('company', $projectData['company_id']);
$location = $projectData['company_location_id'] ? $crud->selectId('company_locations', $projectData['company_location_id']) : false;
$contact = $crud->selectId('contact', $projectData['primary_contact_id']);
$status = $crud->selectId('status', $projectData['status_id']);
$services = $project->getServices($id);
$statusesById = array_column($crud->select('status'), null, 'id');
$tasks = $task->getByProject($id);

$pageTitle = $projectData['title'];
require __DIR__ . '/includes/header.php';
?>

<div class="app-layout">
    <?php require __DIR__ . '/includes/sidebar.php'; ?>

    <main class="main-content" id="main-content">
        <div class="page-body">

            <div class="page-heading">
                <div>
                    <h1><?= htmlspecialchars($projectData['title']) ?></h1>
                    <p><a href="index.php">&larr; Retour aux projets</a></p>
                </div>
                <a href="project-edit.php?id=<?= $id ?>" class="button button--secondary">Modifier le projet</a>
            </div>

            <?php if (isset($_GET['created'])): ?>
                <div class="alert alert--success" style="margin-bottom: var(--space-6)">
                    <p class="alert__text">Tâche créée avec succès.</p>
                </div>
            <?php endif; ?>

            <section class="main-container">
                <div class="card__header">
                    <div>
                        <h2 class="card__title">Informations générales</h2>
                    </div>
                </div>
                <p><strong>Entreprise : </strong><a href="company-show.php?id=<?= (int) $projectData['company_id'] ?>"><?= htmlspecialchars($company['name'] ?? '—') ?></a></p>
                <p><strong>Bureau : </strong><?= $location ? htmlspecialchars($location['name']) : '—' ?></p>
                <p><strong>Contact principal : </strong><?= $contact ? htmlspecialchars($contact['first_name'] . ' ' . $contact['last_name']) : '—' ?></p>
                <p><strong>Statut : </strong><?= $status ? htmlspecialchars($status['name']) : '—' ?></p>
                <p><strong>Début prévu : </strong><?= $projectData['planned_start_date'] ? htmlspecialchars($projectData['planned_start_date']) : '—' ?></p>
                <p><strong>Fin prévue : </strong><?= $projectData['planned_end_date'] ? htmlspecialchars($projectData['planned_end_date']) : '—' ?></p>
                <p><strong>Description : </strong><?= $projectData['description'] ? nl2br(htmlspecialchars($projectData['description'])) : '—' ?></p>
            </section>

            <?php if ($services): ?>
                <section class="main-container">
                    <div class="card__header">
                        <div>
                            <h3 class="card__title">Services</h3>
                        </div>
                    </div>
                    <div class="badge-list">
                        <?php foreach ($services as $service): ?>
                            <span class="badge"><?= htmlspecialchars($service['name']) ?></span>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>

            <section class="main-container">
                <div class="card__header">
                    <div>
                        <h3 class="card__title">Tâches</h3>
                    </div>
                    <a href="task-create.php?project_id=<?= $id ?>" class="button button--secondary">+ Ajouter une tâche</a>
                </div>
                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th scope="col">Tâche</th>
                                <th scope="col">Statut</th>
                                <th scope="col">Début prévu</th>
                                <th scope="col">Fin prévue</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!$tasks): ?>
                                <tr>
                                    <td colspan="5" class="data-table__empty">Aucune tâche associée à ce projet.</td>
                                </tr>
                                <?php else: foreach ($tasks as $t):
                                    $taskStatus = $statusesById[$t['status_id']] ?? null;
                                ?>
                                    <tr>
                                        <td><?= htmlspecialchars($t['title']) ?></td>
                                        <td><?= $taskStatus ? htmlspecialchars($taskStatus['name']) : '—' ?></td>
                                        <td><?= $t['planned_start_date'] ? htmlspecialchars($t['planned_start_date']) : '—' ?></td>
                                        <td><?= $t['planned_end_date'] ? htmlspecialchars($t['planned_end_date']) : '—' ?></td>
                                        <td class="data-table__actions">
                                            <a class="button button--secondary" href="task-edit.php?id=<?= $t['id'] ?>">Modifier</a>
                                            <form action="task-delete.php" method="post" data-confirm="Supprimer cette tâche ?">
                                                <input type="hidden" name="id" value="<?= $t['id'] ?>">
                                                <input type="hidden" name="project_id" value="<?= $id ?>">
                                                <button type="submit" class="button button--danger">Supprimer</button>
                                            </form>
                                        </td>
                                    </tr>
                            <?php endforeach;
                            endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

        </div>
    </main>
</div>

</body>

</html>