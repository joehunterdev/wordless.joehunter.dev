<?php
/** @var \Wordless\Content\Content $content */
$layout    = 'base';
$pageTitle = $content->title;
?>
<article>
    <?= $content->body ?>
</article>
