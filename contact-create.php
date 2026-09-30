<?php
if (!isset($_GET['company_id']) or $_GET['company_id'] == null) {
    header('location:companies.php');
    die();
}
$companyId = $_GET['company_id'];

require_once __DIR__ . '/Classe/CRUD.php';
require_once __DIR__ . '/Classe/Company.php';

$crud = new CRUD;
$company = new Company($crud);
$companyData = $company->find($companyId);

if (!$companyData) {
    header('location:companies.php');
    die();
}

$locations = $company->getLocations($companyId);
$pageTitle = 'Nouveau contact';
require __DIR__ . '/includes/header.php';
?>

<div class="app-layout">
    <?php require __DIR__ . '/includes/sidebar.php'; ?>

    <main class="main-content" id="main-content">
        <div class="page-body">

            <div class="page-heading">
                <div>
                    <h1>Ajouter un contact</h1>
                    <p>Entreprise : <strong><?= htmlspecialchars($companyData['name']) ?></strong></p>
                </div>
                <a href="company-show.php?id=<?= $companyId ?>" class="button button--secondary">Retour à la fiche</a>
            </div>

            <form method="post" action="contact-store.php">
                <section class="main-container">
                    <div class="card__header">
                        <div>
                            <h2 class="card__title">Informations du contact</h2>
                        </div>
                    </div>
                    <div class="form-grid">
                        <input type="hidden" name="company_id" value="<?= $companyId ?>">
                        <div>
                            <div class="form-field">
                                <label class="form-label" for="first_name">Prénom <span style="color:var(--error-text-color)">*</span></label>
                                <input id="first_name" name="first_name" class="form-input" required placeholder="Prénom">
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="last_name">Nom <span style="color:var(--error-text-color)">*</span></label>
                                <input id="last_name" name="last_name" class="form-input" required placeholder="Nom">
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="job_title">Titre du poste</label>
                                <input id="job_title" name="job_title" class="form-input" placeholder="Directeur">
                            </div>
                        </div>
                        <div>
                            <div class="form-field">
                                <label class="form-label" for="company_location_id">Emplacement</label>
                                <select id="company_location_id" name="company_location_id" class="form-select">
                                    <option value="">-- Aucun --</option>
                                    <?php foreach ($locations as $loc): ?>
                                        <option value="<?= $loc['id'] ?>"><?= htmlspecialchars($loc['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="phone">Téléphone</label>
                                <input id="phone" name="phone" class="form-input" placeholder="+1 555-555-5555">
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="email">Courriel</label>
                                <input id="email" name="email" class="form-input" placeholder="contact@company.com">
                            </div>
                        </div>
                    </div>
                </section>

                <div class="form-field">
                    <button type="submit" class="button button--primary">Enregistrer le contact</button>
                </div>
            </form>

        </div>
    </main>
</div>

</body>

</html>