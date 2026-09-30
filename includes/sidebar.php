<aside class="sidebar">
    <a class="sidebar__brand" href="index.php">
        <span class="sidebar__logo" aria-hidden="true">CI</span>

        <span>
            <strong class="sidebar__name">Craft Industria</strong>
            <span class="sidebar__subtitle">Gestion de projets</span>
        </span>
    </a>

    <?php $currentPage = basename($_SERVER['PHP_SELF']); ?>
    <nav class="sidebar__nav" aria-label="Navigation principale">
        <?php $projectPages = ['index.php', 'project-create.php', 'project-show.php', 'project-edit.php', 'task-create.php', 'task-edit.php']; ?>

        <a class="sidebar__link <?= in_array($currentPage, $projectPages) ? 'sidebar__link--active' : '' ?>" href="index.php" <?= in_array($currentPage, $projectPages) ? 'aria-current="page"' : '' ?>>
            <img class="icon" src="assets/icons/folder.svg" alt="">
            <span>Projets</span>
        </a>
        <?php $companyPages = ['companies.php', 'company-create.php', 'company-show.php', 'company-edit.php', 'location-create.php', 'location-edit.php', 'contact-create.php', 'contact-edit.php']; ?>
        <a class="sidebar__link <?= in_array($currentPage, $companyPages) ? 'sidebar__link--active' : '' ?>" href="companies.php" <?= in_array($currentPage, $companyPages) ? 'aria-current="page"' : '' ?>>
            <img class="icon" src="assets/icons/building.svg" alt="">
            <span>Entreprises</span>
        </a>
    </nav>


</aside>