<?php
$basePath = $basePath ?? '';
$currentPage = $currentPage ?? '';

if (!function_exists('isActivePage')) {
    function isActivePage(string $currentPage, string $pageName): string
    {
        return $currentPage === $pageName ? ' aria-current="page"' : '';
    }
}
?>

<aside class="sidebar">
    <input type="checkbox" id="nav-toggle" class="nav-toggle">

    <div class="sidebar__top">
        <div class="sidebar__logo">
            <a href="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8'); ?>index.php"><h1>J</h1></a>
        </div>

        <label for="nav-toggle" class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </label>
    </div>

    <nav class="sidebar__nav">
        <a href="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8'); ?>pages/about.php"<?= isActivePage($currentPage, 'about'); ?>>About Me</a>
        <a href="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8'); ?>index.php#portfolio"<?= isActivePage($currentPage, 'portfolio'); ?>>My Portfolio</a>
        <a href="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8'); ?>pages/coding-examples.php"<?= isActivePage($currentPage, 'coding-examples'); ?>>Coding Examples</a>
        <a href="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8'); ?>pages/scs-scheme.php"<?= isActivePage($currentPage, 'scs-scheme'); ?>>SCS Scheme</a>
        <a href="<?= htmlspecialchars($basePath, ENT_QUOTES, 'UTF-8'); ?>index.php#contact" class="contact-nav"<?= isActivePage($currentPage, 'contact'); ?>>Contact Me</a>
    </nav>

    <div class="sidebar__socials">
        <a href="#" class="sidebar__social-link icon-facebook" target="_blank" rel="noopener noreferrer"></a>
        <a href="#" class="sidebar__social-link icon-instagram" target="_blank" rel="noopener noreferrer"></a>
        <a href="#" class="sidebar__social-link icon-twitter" target="_blank" rel="noopener noreferrer"></a>
        <a href="https://www.linkedin.com/in/jonathan-connell-60753135b" class="sidebar__social-link icon-linkedin2" target="_blank" rel="noopener noreferrer"></a>
    </div>
</aside>