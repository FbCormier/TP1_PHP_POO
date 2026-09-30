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

$pageTitle = 'Nouvel emplacement';
require __DIR__ . '/includes/header.php';
?>

<div class="app-layout">
    <?php require __DIR__ . '/includes/sidebar.php'; ?>

    <main class="main-content" id="main-content">
        <div class="page-body">

            <div class="page-heading">
                <div>
                    <h1>Ajouter un emplacement</h1>
                    <p>Entreprise : <strong><?= htmlspecialchars($companyData['name']) ?></strong></p>
                </div>
                <a href="company-show.php?id=<?= $companyId ?>" class="button button--secondary">Retour à la fiche</a>
            </div>

            <form method="post" action="location-store.php">
                <section class="main-container">
                    <div class="card__header">
                        <div>
                            <h2 class="card__title">Informations de l'emplacement</h2>
                        </div>
                    </div>
                    <div class="form-grid">
                        <input type="hidden" name="company_id" value="<?= $companyId ?>">
                        <div>
                            <div class="form-field">
                                <label class="form-label" for="name">Nom du lieu <span style="color:var(--error-text-color)">*</span></label>
                                <input id="name" name="name" class="form-input" required placeholder="Maison-mère">
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="address">Adresse</label>
                                <input id="address" name="address" class="form-input" placeholder="123 rue Exemple">
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="unit">Unit / Suite</label>
                                <input id="unit" name="unit" class="form-input" placeholder="Unit 4">
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="city">Ville</label>
                                <input id="city" name="city" class="form-input" placeholder="Montréal">
                            </div>
                        </div>
                        <div>
                            <div class="form-field">
                                <label class="form-label" for="region">Région / Province</label>
                                <input id="region" name="region" class="form-input" placeholder="Québec">
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="postal_code">Code postal</label>
                                <input id="postal_code" name="postal_code" class="form-input" placeholder="H0H 0H0">
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="country">Pays</label>
                                <input id="country" name="country" class="form-input" placeholder="Canada">
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
                    <button type="submit" class="button button--primary">Enregistrer l'emplacement</button>
                </div>
            </form>

        </div>
    </main>
</div>

</body>

</html>