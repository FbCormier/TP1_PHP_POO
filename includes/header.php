<?php
$pageTitle = $pageTitle ?? 'Projets';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars(
                $pageTitle . ' — Craft Industria',
                ENT_QUOTES,
                'UTF-8'
            ) ?></title>
    <script src="assets/js/app.js" defer></script>

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <header class="topbar">
        <span class="topbar__brand">Craft Industria</span>
        <span class="topbar__page">
            <?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?>
        </span>
    </header>