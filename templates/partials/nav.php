<?php
/** @var Wordless\Templating\Renderer $renderer */
/** @var string $currentPath */
$currentPath = $currentPath ?? '';
?>
<header>
    <a href="/" class="site-logo">
        <img src="/assets/img/logo.png" alt="Wordless" height="48">
    </a>
    <button class="mobile-toggle" onclick="toggleMobileMenu()" aria-label="Toggle navigation">☰</button>
    <?= $renderer->renderMenu($currentPath) ?>
</header>
