<?php
require_once __DIR__ . '/Classe/CRUD.php';
require_once __DIR__ . '/Classe/Status.php';

$crud = new CRUD;
$status = new Status($crud);
$statuses = $status->all('display_order');
$pageTitle = 'Statuts';

require __DIR__ . '/includes/header.php';
?>

<div class="app-layout">
    <?php require __DIR__ . '/includes/sidebar.php'; ?>

    <main class="main-content" id="main-content">
        <div class="page-body">

            <div class="page-heading">
                <div>
                    <h1>Statuts</h1>
                    <p>Gérez les statuts utilisés pour les projets et les tâches.</p>
                </div>
                <a href="status-create.php" class="button button--primary">+ Ajouter un statut</a>
            </div>

            <?php if (isset($_GET['created'])): ?>
                <div class="alert alert--success" style="margin-bottom: var(--space-6)">
                    <p class="alert__text">Statut ajouté avec succès.</p>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert--error" style="margin-bottom: var(--space-6)">
                    <p class="alert__text">Impossible de supprimer ce statut : il est encore utilisé par des projets ou des tâches.</p>
                </div>
            <?php endif; ?>

            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th scope="col">Statut</th>
                            <th scope="col">Couleur</th>
                            <th scope="col">Ordre</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!$statuses): ?>
                            <tr>
                                <td colspan="4" class="data-table__empty">Aucun statut à afficher.</td>
                            </tr>
                            <?php else: foreach ($statuses as $s): ?>
                                <tr>
                                    <td><?= htmlspecialchars($s['name']) ?></td>
                                    <td>
                                        <span style="display:inline-block;width:16px;height:16px;border-radius:50%;background-color:<?= htmlspecialchars($s['color']) ?>;vertical-align:middle;margin-right:6px;"></span>
                                        <?= htmlspecialchars($s['color']) ?>
                                    </td>
                                    <td><?= (int) $s['display_order'] ?></td>
                                    <td class="data-table__actions">
                                        <a class="button button--secondary" href="status-edit.php?id=<?= $s['id'] ?>">Modifier</a>
                                        <form method="post" action="status-delete.php" data-confirm="Supprimer ce statut ?" style="display:inline">
                                            <input type="hidden" name="id" value="<?= $s['id'] ?>">
                                            <button type="submit" class="button button--danger">Supprimer</button>
                                        </form>
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