<?php
/** @var string      $slot      Rendered page content */
/** @var string|null  $pageTitle Page-level title */
/** @var array        $pageMeta  Full merged meta array */
/** @var \Wordless\Templating\Renderer $renderer */
$pageMeta = $pageMeta ?? $content->meta ?? [];
$lang     = htmlspecialchars($pageMeta['lang'] ?? 'en');
$dir      = htmlspecialchars($pageMeta['dir'] ?? 'ltr');
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<?= $renderer->partial('head', ['pageTitle' => $pageTitle ?? '', 'pageMeta' => $pageMeta, 'currentPath' => $currentPath ?? '']) ?>
<body>
    <div class="site-wrapper">
        <?= $renderer->partial('nav', ['currentPath' => $currentPath ?? '', 'pageMeta' => $pageMeta]) ?>
        <main>
            <?= $slot ?? '' ?>
        </main>
        <?= $renderer->partial('footer') ?>
    </div>
</body>
</html>
