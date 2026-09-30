<?php
if (!isset($_GET['id']) or $_GET['id'] == null) {
    header('location:companies.php');
    die();
}
$id = $_GET['id'];

require_once __DIR__ . '/Classe/CRUD.php';
require_once __DIR__ . '/Classe/CompanyLocation.php';

$crud = new CRUD;
$location = new CompanyLocation($crud);
$locationData = $location->find($id);

if (!$locationData) {
    header('location:companies.php');
    die();
}

extract($locationData);
$pageTitle = 'Modifier ' . $name;
require __DIR__ . '/includes/header.php';
?>

<div class="app-layout">
    <?php require __DIR__ . '/includes/sidebar.php'; ?>

    <main class="main-content" id="main-content">
        <div class="page-body">

            <div class="page-heading">
                <div>
                    <h1>Modifier l'emplacement</h1>
                    <p><a href="company-show.php?id=<?= $company_id ?>">&larr; Retour à la fiche</a></p>
                </div>
            </div>

            <form method="post" action="location-update.php">
                <section class="main-container">
                    <div class="card__header">
                        <div>
                            <h2 class="card__title">Informations de l'emplacement</h2>
                        </div>
                    </div>
                    <div class="form-grid">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <input type="hidden" name="company_id" value="<?= $company_id ?>">
                        <div>
                            <div class="form-field">
                                <label class="form-label" for="name">Nom du lieu <span style="color:var(--error-text-color)">*</span></label>
                                <input id="name" name="name" class="form-input" required value="<?= htmlspecialchars($name) ?>">
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="address">Adresse</label>
                                <input id="address" name="address" class="form-input" value="<?= htmlspecialchars($address ?? '') ?>">
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="unit">Unit / Suite</label>
                                <input id="unit" name="unit" class="form-input" value="<?= htmlspecialchars($unit ?? '') ?>">
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="city">Ville</label>
                                <input id="city" name="city" class="form-input" value="<?= htmlspecialchars($city ?? '') ?>">
                            </div>
                        </div>
                        <div>
                            <div class="form-field">
                                <label class="form-label" for="region">Région / Province</label>
                                <input id="region" name="region" class="form-input" value="<?= htmlspecialchars($region ?? '') ?>">
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="postal_code">Code postal</label>
                                <input id="postal_code" name="postal_code" class="form-input" value="<?= htmlspecialchars($postal_code ?? '') ?>">
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="country">Pays</label>
                                <input id="country" name="country" class="form-input" value="<?= htmlspecialchars($country ?? '') ?>">
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