<?php
require_once __DIR__ . '/Classe/CRUD.php';
$crud = new CRUD();
$pageTitle = 'Nouveau projet';

$companies = $crud->select('company', 'name');
$locations = $crud->select('company_locations', 'name');
$contacts = $crud->select('contact', 'first_name');
$statuses = $crud->select('status', 'display_order');
$services = $crud->select('service', 'name');
$companiesById = array_column($companies, null, 'id');

require __DIR__ . '/includes/header.php';
?>

<div class="app-layout">
    <?php require __DIR__ . '/includes/sidebar.php'; ?>

    <main class="main-content" id="main-content">
        <div class="page-body">

            <div class="page-heading">
                <div>
                    <h1>Nouveau projet</h1>
                    <p>Associez le projet à une entreprise, un bureau et un contact principal.</p>
                </div>
                <a href="index.php" class="button button--secondary">Retour à la liste</a>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert--error" style="margin-bottom: var(--space-6)">
                    <p class="alert__title">Impossible d'enregistrer le projet</p>
                    <p class="alert__text">Le titre, l'entreprise, le contact principal et le statut sont requis.</p>
                </div>
            <?php endif; ?>

            <?php if (!$companies): ?>
                <div class="alert alert--warning" style="margin-bottom: var(--space-6)">
                    <p class="alert__text">Aucune entreprise enregistrée. <a href="company-create.php">Créez d'abord une entreprise</a>.</p>
                </div>
            <?php endif; ?>

            <form method="post" action="project-store.php">

                <section class="main-container">
                    <div class="card__header">
                        <div>
                            <h2 class="card__title">Informations générales</h2>
                            <p class="card__meta">Titre, description et échéancier du projet.</p>
                        </div>
                    </div>
                    <div class="form-grid">
                        <div>
                            <div class="form-field">
                                <label class="form-label" for="title">Titre du projet <span style="color:var(--error-text-color)">*</span></label>
                                <input id="title" name="title" class="form-input" required placeholder="Refonte du site web" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>">
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="description">Description</label>
                                <textarea id="description" name="description" class="form-textarea" placeholder="Détails du mandat"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
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
                                    <option value="">-- Choisir une entreprise --</option>
                                    <?php foreach ($companies as $c): ?>
                                        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="company_location_id">Bureau</label>
                                <select id="company_location_id" name="company_location_id" class="form-select">
                                    <option value="">-- Aucun --</option>
                                    <?php foreach ($locations as $loc): ?>
                                        <option value="<?= $loc['id'] ?>"><?= htmlspecialchars($loc['name']) ?> — <?= htmlspecialchars($companiesById[$loc['company_id']]['name'] ?? '') ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div>
                            <div class="form-field">
                                <label class="form-label" for="primary_contact_id">Contact principal <span style="color:var(--error-text-color)">*</span></label>
                                <select id="primary_contact_id" name="primary_contact_id" class="form-select" required>
                                    <option value="">-- Choisir un contact --</option>
                                    <?php foreach ($contacts as $contact): ?>
                                        <option value="<?= $contact['id'] ?>"><?= htmlspecialchars($contact['first_name'] . ' ' . $contact['last_name']) ?> — <?= htmlspecialchars($companiesById[$contact['company_id']]['name'] ?? '') ?></option>
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
                                    <input type="checkbox" name="service_ids[]" value="<?= $service['id'] ?>">
                                    <span><?= htmlspecialchars($service['name']) ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>

                <div class="form-field">
                    <button type="submit" class="button button--primary">Enregistrer le projet</button>
                </div>
            </form>

        </div>
    </main>
</div>

</body>

</html>