<?php
/** @var string      $slot      Rendered page content */
/** @var string|null  $pageTitle Page-level title */
/** @var \Wordless\Templating\Renderer $renderer */
?>
<!DOCTYPE html>
<html lang="en">
<?= $renderer->partial('head', ['pageTitle' => $pageTitle ?? '']) ?>
<body>
    <?= $renderer->partial('nav') ?>
    <main>
        <?= $slot ?? '' ?>
    </main>
    <?= $renderer->partial('footer') ?>
</body>
</html>
