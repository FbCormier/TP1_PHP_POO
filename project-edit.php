<?php
if (!isset($_GET['id']) or $_GET['id'] == null) {
    header('location:index.php');
    die();
}
$id = $_GET['id'];

require_once __DIR__ . '/Classe/CRUD.php';
require_once __DIR__ . '/Classe/Project.php';

$crud = new CRUD;
$project = new Project($crud);
$projectData = $project->find($id);

if (!$projectData) {
    header('location:index.php');
    die();
}

$companies = $crud->select('company', 'name');
$locations = $crud->select('company_locations', 'name');
$contacts = $crud->select('contact', 'first_name');
$statuses = $crud->select('status', 'display_order');
$services = $crud->select('service', 'name');
$projectServiceIds = array_column($project->getServices($id), 'id');
$companiesById = array_column($companies, null, 'id');

extract($projectData);
$pageTitle = 'Modifier ' . $title;
require __DIR__ . '/includes/header.php';
?>

<div class="app-layout">
    <?php require __DIR__ . '/includes/sidebar.php'; ?>

    <main class="main-content" id="main-content">
        <div class="page-body">

            <div class="page-heading">
                <div>
                    <h1>Modifier le projet</h1>
                    <p><a href="project-show.php?id=<?= $id ?>">&larr; Retour à la fiche</a></p>
                </div>
            </div>

            <form method="post" action="project-update.php">

                <section class="main-container">
                    <div class="card__header">
                        <div>
                            <h2 class="card__title">Informations générales</h2>
                            <p class="card__meta">Titre, description et échéancier du projet.</p>
                        </div>
                    </div>
                    <div class="form-grid">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <div>
                            <div class="form-field">
                                <label class="form-label" for="title">Titre du projet <span style="color:var(--error-text-color)">*</span></label>
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

                <section class="main-container">
                    <div class="card__header">
                        <div>
                            <h2 class="card__title">Client</h2>
                            <p class="card__meta">Entreprise, bureau et contact principal du projet.</p>
                        </div>
                    </div>
                    <div class="form-grid">
                        <div>
                            <div class="form-field">
                                <label class="form-label" for="company_id">Entreprise <span style="color:var(--error-text-color)">*</span></label>
                                <select id="company_id" name="company_id" class="form-select" required>
                                    <?php foreach ($companies as $c): ?>
                                        <option value="<?= $c['id'] ?>" <?= $c['id'] == $company_id ? 'selected' : '' ?>><?= htmlspecialchars($c['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="company_location_id">Bureau</label>
                                <select id="company_location_id" name="company_location_id" class="form-select">
                                    <option value="">-- Aucun --</option>
                                    <?php foreach ($locations as $loc): ?>
                                        <option value="<?= $loc['id'] ?>" <?= $loc['id'] == $company_location_id ? 'selected' : '' ?>><?= htmlspecialchars($loc['name']) ?> — <?= htmlspecialchars($companiesById[$loc['company_id']]['name'] ?? '') ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div>
                            <div class="form-field">
                                <label class="form-label" for="primary_contact_id">Contact principal <span style="color:var(--error-text-color)">*</span></label>
                                <select id="primary_contact_id" name="primary_contact_id" class="form-select" required>
                                    <?php foreach ($contacts as $contact): ?>
                                        <option value="<?= $contact['id'] ?>" <?= $contact['id'] == $primary_contact_id ? 'selected' : '' ?>><?= htmlspecialchars($contact['first_name'] . ' ' . $contact['last_name']) ?> — <?= htmlspecialchars($companiesById[$contact['company_id']]['name'] ?? '') ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </section>

                <?php if ($services): ?>
                    <section class="main-container">
                        <div class="card__header">
                            <div>
                                <h2 class="card__title">Services</h2>
                                <p class="card__meta">Services inclus dans ce projet.</p>
                            </div>
                        </div>
                        <div class="badge-list">
                            <?php foreach ($services as $service): ?>
                                <label class="form-field" style="flex-direction: row; align-items: center; gap: var(--space-2)">
                                    <input type="checkbox" name="service_ids[]" value="<?= $service['id'] ?>" <?= in_array($service['id'], $projectServiceIds) ? 'checked' : '' ?>>
                                    <span><?= htmlspecialchars($service['name']) ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>

                <div class="form-field">
                    <button type="submit" class="button button--primary">Enregistrer les modifications</button>
                </div>
            </form>

        </div>
    </main>
</div>

</body>

</html>