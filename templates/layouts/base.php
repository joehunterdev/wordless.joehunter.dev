<?php
/** @var string      $slot      Rendered page content */
/** @var string|null  $pageTitle Page-level title */
/** @var \Wordless\Templating\Renderer $renderer */
?>
<!DOCTYPE html>
<html lang="en">
<?= $renderer->partial('head', ['pageTitle' => $pageTitle ?? '']) ?>
<body>
    <div class="site-wrapper">
        <?= $renderer->partial('nav') ?>
        <main>
            <?= $slot ?? '' ?>
        </main>
        <?= $renderer->partial('footer') ?>
    </div>
</body>
</html>
