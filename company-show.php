<?php
if (!isset($_GET['id']) or $_GET['id'] == null) {
    header('location:companies.php');
    die();
}
$id = $_GET['id'];

require_once __DIR__ . '/Classe/CRUD.php';
require_once __DIR__ . '/Classe/Company.php';

$crud = new CRUD;
$company = new Company($crud);
$companyData = $company->find($id);

if (!$companyData) {
    header('location:companies.php');
    die();
}

$locations = $company->getLocations($id);
$contacts = $company->getContacts($id);
$projects = $company->getProjects($id);
$locationsById = array_column($locations, null, 'id');
$statusesById = array_column($crud->select('status'), null, 'id');

$pageTitle = $companyData['name'];
require __DIR__ . '/includes/header.php';
?>

<div class="app-layout">
    <?php require __DIR__ . '/includes/sidebar.php'; ?>

    <main class="main-content" id="main-content">
        <div class="page-body">

            <div class="page-heading">
                <div>
                    <h1><?= htmlspecialchars($companyData['name']) ?></h1>
                    <p><a href="companies.php">&larr; Retour aux entreprises</a></p>
                </div>
                <a href="company-edit.php?id=<?= $id ?>" class="button button--secondary">Modifier l'entreprise</a>
            </div>

            <?php if (isset($_GET['created'])): ?>
                <div class="alert alert--success" style="margin-bottom: var(--space-6)">
                    <p class="alert__text">Entreprise ajoutée avec succès.</p>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert--error" style="margin-bottom: var(--space-6)">
                    <p class="alert__text">Impossible de supprimer : des contacts, emplacements ou projets y sont encore associés.</p>
                </div>
            <?php endif; ?>

            <section class="main-container">
                <div class="card__header">
                    <div>
                        <h2 class="card__title">Informations générales</h2>
                    </div>
                </div>
                <p><strong>Nom : </strong><?= htmlspecialchars($companyData['name']) ?></p>
                <p><strong>Website : </strong>
                    <?php if ($companyData['website']): ?>
                        <a href="<?= htmlspecialchars($companyData['website']) ?>" target="_blank" rel="noopener"><?= htmlspecialchars($companyData['website']) ?></a>
                    <?php else: ?>
                        —
                    <?php endif; ?>
                </p>
            </section>

            <section class="main-container">
                <div class="card__header">
                    <div>
                        <h3 class="card__title">Contacts</h3>
                    </div>
                    <a href="contact-create.php?company_id=<?= $id ?>" class="button button--secondary">+ Ajouter un contact</a>
                </div>
                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th scope="col">Nom</th>
                                <th scope="col">Fonction</th>
                                <th scope="col">Courriel</th>
                                <th scope="col">Téléphone</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!$contacts): ?>
                                <tr>
                                    <td colspan="5" class="data-table__empty">Aucun contact associé à cette entreprise.</td>
                                </tr>
                                <?php else: foreach ($contacts as $contact): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($contact['first_name'] . ' ' . $contact['last_name']) ?></td>
                                        <td><?= htmlspecialchars($contact['job_title'] ?? '—') ?></td>
                                        <td><?= htmlspecialchars($contact['email'] ?? '—') ?></td>
                                        <td><?= htmlspecialchars($contact['phone'] ?? '—') ?></td>
                                        <td class="data-table__actions">
                                            <a class="button button--secondary" href="contact-edit.php?id=<?= $contact['id'] ?>">Modifier</a>
                                        </td>
                                    </tr>
                            <?php endforeach;
                            endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="main-container">
                <div class="card__header">
                    <div>
                        <h3 class="card__title">Emplacements</h3>
                    </div>
                    <a href="location-create.php?company_id=<?= $id ?>" class="button button--secondary">+ Ajouter un emplacement</a>
                </div>
                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th scope="col">Emplacement</th>
                                <th scope="col">Adresse</th>
                                <th scope="col">Ville</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!$locations): ?>
                                <tr>
                                    <td colspan="4" class="data-table__empty">Aucun emplacement associé à cette entreprise.</td>
                                </tr>
                                <?php else: foreach ($locations as $loc): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($loc['name']) ?></td>
                                        <td><?= htmlspecialchars($loc['address'] ?? '—') ?></td>
                                        <td><?= htmlspecialchars($loc['city'] ?? '—') ?></td>
                                        <td class="data-table__actions">
                                            <a class="button button--secondary" href="location-edit.php?id=<?= $loc['id'] ?>">Modifier</a>
                                        </td>
                                    </tr>
                            <?php endforeach;
                            endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="main-container">
                <div class="card__header">
                    <div>
                        <h3 class="card__title">Projets</h3>
                    </div>
                    <a href="project-create.php" class="button button--secondary">+ Ajouter un projet</a>
                </div>
                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th scope="col">Projet</th>
                                <th scope="col">Statut</th>
                                <th scope="col">Début prévu</th>
                                <th scope="col">Fin prévue</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!$projects): ?>
                                <tr>
                                    <td colspan="5" class="data-table__empty">Aucun projet associé à cette entreprise.</td>
                                </tr>
                                <?php else: foreach ($projects as $proj):
                                    $status = $statusesById[$proj['status_id']] ?? null;
                                ?>
                                    <tr>
                                        <td><?= htmlspecialchars($proj['title']) ?></td>
                                        <td><?= $status ? htmlspecialchars($status['name']) : '—' ?></td>
                                        <td><?= $proj['planned_start_date'] ? htmlspecialchars($proj['planned_start_date']) : '—' ?></td>
                                        <td><?= $proj['planned_end_date'] ? htmlspecialchars($proj['planned_end_date']) : '—' ?></td>
                                        <td class="data-table__actions">
                                            <a class="button button--secondary" href="project-show.php?id=<?= (int) $proj['id'] ?>">Voir</a>
                                        </td>
                                    </tr>
                            <?php endforeach;
                            endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <form action="company-delete.php" method="post" data-confirm="Supprimer cette entreprise ?">
                <input type="hidden" name="id" value="<?= $id ?>">
                <button type="submit" class="button button--danger">Supprimer l'entreprise</button>
            </form>

        </div>
    </main>
</div>

</body>

</html>