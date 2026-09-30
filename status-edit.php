<?php
if (!isset($_GET['id']) or $_GET['id'] == null) {
    header('location:statuses.php');
    die();
}
$id = $_GET['id'];

require_once __DIR__ . '/Classe/CRUD.php';
require_once __DIR__ . '/Classe/Status.php';

$crud = new CRUD;
$status = new Status($crud);
$statusData = $status->find($id);

if (!$statusData) {
    header('location:statuses.php');
    die();
}

extract($statusData);
$pageTitle = 'Modifier ' . $name;
require __DIR__ . '/includes/header.php';
?>

<div class="app-layout">
    <?php require __DIR__ . '/includes/sidebar.php'; ?>

    <main class="main-content" id="main-content">
        <div class="page-body">

            <div class="page-heading">
                <div>
                    <h1>Modifier le statut</h1>
                    <p><a href="statuses.php">&larr; Retour à la liste</a></p>
                </div>
            </div>

            <form method="post" action="status-update.php">
                <section class="main-container">
                    <div class="card__header">
                        <div>
                            <h2 class="card__title">Informations du statut</h2>
                        </div>
                    </div>
                    <div class="form-grid">
                        <div>
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <div class="form-field">
                                <label class="form-label" for="name">Nom du statut <span style="color:var(--error-text-color)">*</span></label>
                                <input id="name" name="name" class="form-input" required value="<?= htmlspecialchars($name) ?>">
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="color">Couleur</label>
                                <input type="color" id="color" name="color" class="form-input" value="<?= htmlspecialchars($color) ?>">
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="display_order">Ordre d'affichage</label>
                                <input type="number" id="display_order" name="display_order" class="form-input" value="<?= (int) $display_order ?>">
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