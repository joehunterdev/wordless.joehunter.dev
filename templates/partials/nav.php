<?php
/** @var Wordless\Templating\Renderer $renderer */
/** @var string $currentPath */
$currentPath = $currentPath ?? '';
?>
<header>
    <button class="mobile-toggle" onclick="toggleMobileMenu()" aria-label="Toggle navigation">☰</button>
    <?= $renderer->renderMenu($currentPath) ?>
</header>
