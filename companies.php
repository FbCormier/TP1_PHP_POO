<?php
require_once __DIR__ . '/Classe/CRUD.php';
require_once __DIR__ . '/Classe/Company.php';

$crud = new CRUD;
$company = new Company($crud);
$companies = $company->all('name');
$pageTitle = 'Entreprises';

require __DIR__ . '/includes/header.php';
?>

<div class="app-layout">
    <?php require __DIR__ . '/includes/sidebar.php'; ?>

    <main class="main-content" id="main-content">
        <div class="page-body">

            <div class="page-heading">
                <div>
                    <h1>Entreprises</h1>
                    <p>Consultez et gérez vos entreprises clientes.</p>
                </div>
                <a href="company-create.php" class="button button--primary">+ Ajouter une entreprise</a>
            </div>

            <?php if (isset($_GET['created'])): ?>
                <div class="alert alert--success" style="margin-bottom: var(--space-6)">
                    <p class="alert__text">Entreprise ajoutée avec succès.</p>
                </div>
            <?php endif; ?>

            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th scope="col">Entreprise</th>
                            <th scope="col">Contacts</th>
                            <th scope="col">Emplacements</th>
                            <th scope="col">Projets</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!$companies): ?>
                            <tr>
                                <td colspan="5" class="data-table__empty">Aucune entreprise à afficher.</td>
                            </tr>
                            <?php else: foreach ($companies as $c): ?>
                                <tr>
                                    <td><a href="company-show.php?id=<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></a></td>
                                    <td><?= count($company->getContacts($c['id'])) ?></td>
                                    <td><?= count($company->getLocations($c['id'])) ?></td>
                                    <td><?= count($company->getProjects($c['id'])) ?></td>
                                    <td class="data-table__actions">
                                        <a class="button button--secondary" href="company-show.php?id=<?= $c['id'] ?>">Voir la fiche</a>
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