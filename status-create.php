<?php
$pageTitle = 'Nouveau statut';
require __DIR__ . '/includes/header.php';
?>

<div class="app-layout">
    <?php require __DIR__ . '/includes/sidebar.php'; ?>

    <main class="main-content" id="main-content">
        <div class="page-body">

            <div class="page-heading">
                <div>
                    <h1>Nouveau statut</h1>
                    <p>Ajoutez un statut pouvant être utilisé sur les projets et les tâches.</p>
                </div>
                <a href="statuses.php" class="button button--secondary">Retour à la liste</a>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert--error" style="margin-bottom: var(--space-6)">
                    <p class="alert__title">Impossible d'enregistrer le statut</p>
                    <p class="alert__text">Le nom du statut est requis.</p>
                </div>
            <?php endif; ?>

            <form method="post" action="status-store.php">
                <section class="main-container">
                    <div class="card__header">
                        <div>
                            <h2 class="card__title">Informations du statut</h2>
                        </div>
                    </div>
                    <div class="form-grid">
                        <div>
                            <div class="form-field">
                                <label class="form-label" for="name">Nom du statut <span style="color:var(--error-text-color)">*</span></label>
                                <input id="name" name="name" class="form-input" required placeholder="Ex: En cours">
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="color">Couleur</label>
                                <input type="color" id="color" name="color" class="form-input" value="#667579">
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="display_order">Ordre d'affichage</label>
                                <input type="number" id="display_order" name="display_order" class="form-input" value="0">
                            </div>
                        </div>
                    </div>
                </section>

                <div class="form-field">
                    <button type="submit" class="button button--primary">Enregistrer le statut</button>
                </div>
            </form>

        </div>
    </main>
</div>

</body>

</html>