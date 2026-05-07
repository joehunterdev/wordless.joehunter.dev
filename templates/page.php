<?php
/** @var \Wordless\Content\Content $content */
$layout    = 'base';
$pageTitle = $content->title;
$pageMeta  = $content->meta;
?>
<article>
    <?= $content->body ?>
</article>
