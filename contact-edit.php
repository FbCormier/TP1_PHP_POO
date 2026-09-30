<?php
if (!isset($_GET['id']) or $_GET['id'] == null) {
    header('location:companies.php');
    die();
}
$id = $_GET['id'];

require_once __DIR__ . '/Classe/CRUD.php';
require_once __DIR__ . '/Classe/Contact.php';
require_once __DIR__ . '/Classe/Company.php';

$crud = new CRUD;
$contact = new Contact($crud);
$contactData = $contact->find($id);

if (!$contactData) {
    header('location:companies.php');
    die();
}

$company = new Company($crud);
$locations = $company->getLocations($contactData['company_id']);

extract($contactData);
$pageTitle = 'Modifier ' . $contact->fullName($contactData);
require __DIR__ . '/includes/header.php';
?>

<div class="app-layout">
    <?php require __DIR__ . '/includes/sidebar.php'; ?>

    <main class="main-content" id="main-content">
        <div class="page-body">

            <div class="page-heading">
                <div>
                    <h1>Modifier le contact</h1>
                    <p><a href="company-show.php?id=<?= $company_id ?>">&larr; Retour à la fiche</a></p>
                </div>
            </div>

            <form method="post" action="contact-update.php">
                <section class="main-container">
                    <div class="card__header">
                        <div>
                            <h2 class="card__title">Informations du contact</h2>
                        </div>
                    </div>
                    <div class="form-grid">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <input type="hidden" name="company_id" value="<?= $company_id ?>">
                        <div>
                            <div class="form-field">
                                <label class="form-label" for="first_name">Prénom <span style="color:var(--error-text-color)">*</span></label>
                                <input id="first_name" name="first_name" class="form-input" required value="<?= htmlspecialchars($first_name) ?>">
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="last_name">Nom <span style="color:var(--error-text-color)">*</span></label>
                                <input id="last_name" name="last_name" class="form-input" required value="<?= htmlspecialchars($last_name) ?>">
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="job_title">Titre du poste</label>
                                <input id="job_title" name="job_title" class="form-input" value="<?= htmlspecialchars($job_title ?? '') ?>">
                            </div>
                        </div>
                        <div>
                            <div class="form-field">
                                <label class="form-label" for="company_location_id">Emplacement</label>
                                <select id="company_location_id" name="company_location_id" class="form-select">
                                    <option value="">-- Aucun --</option>
                                    <?php foreach ($locations as $loc): ?>
                                        <option value="<?= $loc['id'] ?>" <?= $loc['id'] == $company_location_id ? 'selected' : '' ?>><?= htmlspecialchars($loc['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="phone">Téléphone</label>
                                <input id="phone" name="phone" class="form-input" value="<?= htmlspecialchars($phone ?? '') ?>">
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="email">Courriel</label>
                                <input id="email" name="email" class="form-input" value="<?= htmlspecialchars($email ?? '') ?>">
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