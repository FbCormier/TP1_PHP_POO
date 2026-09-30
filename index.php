<?php
require_once __DIR__ . '/Classe/CRUD.php';
require_once __DIR__ . '/Classe/Project.php';
$crud = new CRUD();
$projectModel = new Project($crud);
$pageTitle = 'Projets';

$projects = $projectModel->all('id', 'DESC');
$companiesById = array_column($crud->select('company'), null, 'id');
$statusesById = array_column($crud->select('status'), null, 'id');

require __DIR__ . '/includes/header.php';
?>

<div class="app-layout">
    <?php require __DIR__ . '/includes/sidebar.php'; ?>

    <main class="main-content" id="main-content">
        <div class="page-body">

            <div class="page-heading">
                <div>
                    <h1>Projets</h1>
                    <p>Consultez les mandats de vos entreprises clientes.</p>
                </div>
                <a href="project-create.php" class="button button--primary">+ Nouveau projet</a>
            </div>

            <?php if (isset($_GET['created'])): ?>
                <div class="alert alert--success" style="margin-bottom: var(--space-6)">
                    <p class="alert__text">Projet créé avec succès.</p>
                </div>
            <?php endif; ?>

            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th scope="col">Projet</th>
                            <th scope="col">Entreprise</th>
                            <th scope="col">Statut</th>
                            <th scope="col">Début prévu</th>
                            <th scope="col">Fin prévue</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!$projects): ?>
                            <tr>
                                <td colspan="6" class="data-table__empty">
                                    Aucun projet à afficher.
                                </td>
                            </tr>
                            <?php else: foreach ($projects as $project):
                                $company = $companiesById[$project['company_id']] ?? null;
                                $status = $statusesById[$project['status_id']] ?? null;
                            ?>
                                <tr>
                                    <td><?= htmlspecialchars($project['title']) ?></td>
                                    <td><?= htmlspecialchars($company['name'] ?? '—') ?></td>
                                    <td>
                                        <?php if ($status): ?>
                                            <span class="badge" style="background-color: color-mix(in srgb, <?= htmlspecialchars($status['color']) ?> 15%, white); color: <?= htmlspecialchars($status['color']) ?>"><?= htmlspecialchars($status['name']) ?></span>
                                        <?php else: ?>
                                            —
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $project['planned_start_date'] ? htmlspecialchars($project['planned_start_date']) : '—' ?></td>
                                    <td><?= $project['planned_end_date'] ? htmlspecialchars($project['planned_end_date']) : '—' ?></td>
                                    <td class="data-table__actions">
                                        <a class="button button--secondary" href="project-show.php?id=<?= (int) $project['id'] ?>">Voir</a>
                                        <a class="button button--secondary" href="company-show.php?id=<?= (int) $project['company_id'] ?>">Entreprise</a>
                                    </td>
                                </tr>
                        <?php endforeach;
                        endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </main>
</div>

</body>

</html>