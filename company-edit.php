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

extract($companyData);
$pageTitle = 'Modifier ' . $name;
require __DIR__ . '/includes/header.php';
?>

<div class="app-layout">
    <?php require __DIR__ . '/includes/sidebar.php'; ?>

    <main class="main-content" id="main-content">
        <div class="page-body">

            <div class="page-heading">
                <div>
                    <h1>Modifier l'entreprise</h1>
                    <p><a href="company-show.php?id=<?= $id ?>">&larr; Retour à la fiche</a></p>
                </div>
            </div>

            <form method="post" action="company-update.php">
                <section class="main-container">
                    <div class="card__header">
                        <div>
                            <h2 class="card__title">Informations de l'entreprise</h2>
                        </div>
                    </div>
                    <div class="form-grid">
                        <div>
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <div class="form-field">
                                <label class="form-label" for="name">Nom de la compagnie <span style="color:var(--error-text-color)">*</span></label>
                                <input id="name" name="name" class="form-input" required value="<?= htmlspecialchars($name) ?>">
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="website">Website</label>
                                <input id="website" name="website" class="form-input" value="<?= htmlspecialchars($website ?? '') ?>">
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