<?php
require_once __DIR__ . '/Classe/CRUD.php';
require_once __DIR__ . '/Classe/Service.php';

$crud = new CRUD;
$service = new Service($crud);
$services = $service->all('name');
$pageTitle = 'Services';

require __DIR__ . '/includes/header.php';
?>

<div class="app-layout">
    <?php require __DIR__ . '/includes/sidebar.php'; ?>

    <main class="main-content" id="main-content">
        <div class="page-body">

            <div class="page-heading">
                <div>
                    <h1>Services</h1>
                    <p>Gérez les services pouvant être rattachés aux projets.</p>
                </div>
                <a href="service-create.php" class="button button--primary">+ Ajouter un service</a>
            </div>

            <?php if (isset($_GET['created'])): ?>
                <div class="alert alert--success" style="margin-bottom: var(--space-6)">
                    <p class="alert__text">Service ajouté avec succès.</p>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert--error" style="margin-bottom: var(--space-6)">
                    <p class="alert__text">Impossible de supprimer ce service : il est encore rattaché à des projets.</p>
                </div>
            <?php endif; ?>

            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th scope="col">Service</th>
                            <th scope="col">Description</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!$services): ?>
                            <tr>
                                <td colspan="3" class="data-table__empty">Aucun service à afficher.</td>
                            </tr>
                            <?php else: foreach ($services as $s): ?>
                                <tr>
                                    <td><?= htmlspecialchars($s['name']) ?></td>
                                    <td><?= htmlspecialchars($s['description'] ?? '') ?></td>
                                    <td class="data-table__actions">
                                        <a class="button button--secondary" href="service-edit.php?id=<?= $s['id'] ?>">Modifier</a>
                                        <form method="post" action="service-delete.php" data-confirm="Supprimer ce service ?" style="display:inline">
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