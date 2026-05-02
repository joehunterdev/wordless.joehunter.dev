<?php
/** @var \Wordless\Content\Content $content */
/** @var \Wordless\Templating\Renderer $renderer */

ob_start();
?>
<article>
    <h1><?= htmlspecialchars($content->title) ?></h1>
    <?php if ($content->get('date')): ?>
        <p class="meta" style="color:#888;font-size:0.9rem;">
            <?= htmlspecialchars($content->get('date')) ?>
        </p>
    <?php endif; ?>
    <div class="body">
        <?= $content->body ?>
    </div>
</article>
<?php
$slot      = ob_get_clean();
$pageTitle = $content->title;
require __DIR__ . '/layouts/base.php';
