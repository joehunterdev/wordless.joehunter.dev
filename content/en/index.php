<?php $meta = [
    'title'    => 'English',
    'lang'     => 'en',
    'locale'   => 'en-US',
    'dir'      => 'ltr',
    'peers'    => ['es' => '/es'],
    'keywords' => ['wordless', 'cms', 'php', 'english'],
]; ?>

<?= $renderer->partial('nav', ['currentPath' => $currentPath ?? '', 'pageMeta' => $meta]) ?>

<h1>Welcome</h1>

<p>English language section of Wordless CMS.</p>
