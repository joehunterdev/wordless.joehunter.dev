<?php
/** @var \Wordless\Content\Content $content */
$layout    = 'base';
$pageTitle = $content->title;
?>
<article>
    <h1><?= e($content->title) ?></h1>
    <?php if ($content->get('date')): ?>
        <time class="meta" style="color:#888;font-size:0.9rem;" datetime="<?= e($content->get('date')) ?>">
            <?= e($content->get('date')) ?>
        </time>
    <?php endif; ?>
    <div class="body">
        <?= $content->body ?>
    </div>
</article>
