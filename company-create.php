<?php
$pageTitle = 'Nouvelle entreprise';
require __DIR__ . '/includes/header.php';
?>

<div class="app-layout">
    <?php require __DIR__ . '/includes/sidebar.php'; ?>

    <main class="main-content" id="main-content">
        <div class="page-body">

            <div class="page-heading">
                <div>
                    <h1>Nouvelle entreprise</h1>
                    <p>Renseignez les informations générales de l'entreprise. Vous pourrez ajouter ses contacts et ses emplacements depuis sa fiche.</p>
                </div>
                <a href="companies.php" class="button button--secondary">Retour à la liste</a>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert--error" style="margin-bottom: var(--space-6)">
                    <p class="alert__title">Impossible d'enregistrer l'entreprise</p>
                    <p class="alert__text">Le nom de l'entreprise est requis.</p>
                </div>
            <?php endif; ?>

            <form method="post" action="company-store.php">
                <section class="main-container">
                    <div class="card__header">
                        <div>
                            <h2 class="card__title">Informations de l'entreprise</h2>
                            <p class="card__meta">Nom et site web de l'entreprise.</p>
                        </div>
                    </div>
                    <div class="form-grid">
                        <div>
                            <div class="form-field">
                                <label class="form-label" for="name">Nom de la compagnie <span style="color:var(--error-text-color)">*</span></label>
                                <input id="name" name="name" class="form-input" required placeholder="Nom de la compagnie">
                            </div>
                            <div class="form-field">
                                <label class="form-label" for="website">Website</label>
                                <input id="website" name="website" class="form-input" placeholder="https://example.com">
                            </div>
                        </div>
                    </div>
                </section>

                <div class="form-field">
                    <button type="submit" class="button button--primary">Enregistrer l'entreprise</button>
                </div>
            </form>

        </div>
    </main>
</div>

</body>

</html>