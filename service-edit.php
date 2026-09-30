<?php
if (!isset($_GET['id']) or $_GET['id'] == null) {
    header('location:services.php');
    die();
}
$id = $_GET['id'];

require_once __DIR__ . '/Classe/CRUD.php';
require_once __DIR__ . '/Classe/Service.php';

$crud = new CRUD;
$service = new Service($crud);
$serviceData = $service->find($id);

if (!$serviceData) {
    header('location:services.php');
    die();
}

extract($serviceData);
$pageTitle = 'Modifier ' . $name;
require __DIR__ . '/includes/header.php';
?>

<div class="app-layout">
    <?php require __DIR__ . '/includes/sidebar.php'; ?>

    <main class="main-content" id="main-content">
        <div class="page-body">

            <div class="page-heading">
                <div>
                    <h1>Modifier le service</h1>
                    <p><a href="services.php">&larr; Retour à la liste</a></p>
                </div>
            </div>

            <form method="post" action="service-update.php">
                <section class="main-container">
                    <div class="card__header">
                        <div>
                            <h2 class="card__title">Informations du service</h2>
                        </div>
                    </div>
                    <div class="form-grid">
                        <div>
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <div class="form-field">
                                <label class="form-label" for="name">Nom du service <span style="color:var(--error-text-color)">*</span></label>
                                <input id="name" name="name" class="form-input" required value="<?= htmlspecialchars($name) ?>">
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="description">Description</label>
                                <textarea id="description" name="description" class="form-input" rows="4"><?= htmlspecialchars($description ?? '') ?></textarea>
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