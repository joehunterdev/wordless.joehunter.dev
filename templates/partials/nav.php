<?php
/** @var \Wordless\Templating\Renderer $renderer */
/** @var string $currentPath */
/** @var array  $pageMeta */
$currentPath = $currentPath ?? '';
$pageMeta    = $pageMeta ?? [];
?>
<header>
    <a href="/" class="site-logo">
        <img src="<?= img('logo.png') ?>" alt="Wordless" height="48">
    </a>
    <?= $renderer->renderMenu($currentPath) ?>
    <?= $renderer->partial('lang-switch', ['currentPath' => $currentPath, 'pageMeta' => $pageMeta]) ?>
    <button class="mobile-toggle" onclick="toggleMobileMenu()" aria-label="Toggle navigation">☰</button>
</header>
