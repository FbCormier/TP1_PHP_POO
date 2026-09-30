<?php
$pageTitle = 'Nouveau service';
require __DIR__ . '/includes/header.php';
?>

<div class="app-layout">
    <?php require __DIR__ . '/includes/sidebar.php'; ?>

    <main class="main-content" id="main-content">
        <div class="page-body">

            <div class="page-heading">
                <div>
                    <h1>Nouveau service</h1>
                    <p>Ajoutez un service pouvant être rattaché aux projets.</p>
                </div>
                <a href="services.php" class="button button--secondary">Retour à la liste</a>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert--error" style="margin-bottom: var(--space-6)">
                    <p class="alert__title">Impossible d'enregistrer le service</p>
                    <p class="alert__text">Le nom du service est requis.</p>
                </div>
            <?php endif; ?>

            <form method="post" action="service-store.php">
                <section class="main-container">
                    <div class="card__header">
                        <div>
                            <h2 class="card__title">Informations du service</h2>
                        </div>
                    </div>
                    <div class="form-grid">
                        <div>
                            <div class="form-field">
                                <label class="form-label" for="name">Nom du service <span style="color:var(--error-text-color)">*</span></label>
                                <input id="name" name="name" class="form-input" required placeholder="Ex: Conception">
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="description">Description</label>
                                <textarea id="description" name="description" class="form-input" rows="4" placeholder="Description du service"></textarea>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="form-field">
                    <button type="submit" class="button button--primary">Enregistrer le service</button>
                </div>
            </form>

        </div>
    </main>
</div>

</body>

</html>