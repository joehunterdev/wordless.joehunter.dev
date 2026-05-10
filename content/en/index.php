<?php $meta = [
    'title'       => 'Wordless — Pure PHP Flat-File CMS',
    'description' => 'Wordless is a minimal, dependency-free flat-file CMS built with modern PHP. No database. No Composer. Just clean architecture.',
    'lang'        => 'en',
    'locale'      => 'en-US',
    'dir'         => 'ltr',
    'peers'       => ['es' => '/es'],
    'keywords'    => ['wordless', 'cms', 'php', 'flat-file', 'no database', 'pure php'],
    'menu'        => ['order' => 1, 'title' => 'Home'],
]; ?>

<h1>Wordless</h1>

<p>
    Wordless is a pure PHP, flat-file CMS that treats the filesystem as both content store and architecture.
    No database. No Composer dependencies. No hidden framework layers.
</p>

<h2>What makes Wordless different?</h2>

<ul>
    <li><strong>Filesystem-native routing</strong> — add a file, get a URL</li>
    <li><strong>Content as PHP</strong> — pages declare <code>$meta</code> and render body directly</li>
    <li><strong>Native PHP templates</strong> — no templating engine, no compilation step</li>
    <li><strong>Locale-aware by design</strong> — <code>en/</code> and <code>es/</code> are first-class content trees</li>
    <li><strong>Zero dependencies</strong> — no Composer, no third-party libraries</li>
</ul>

<h2>Explore the documentation</h2>

<ul>
    <li><a href="<?= route('about', 'en') ?>">About Wordless</a> — philosophy and architecture overview</li>
    <li><a href="<?= route('features', 'en') ?>">Features</a> — deep dives into each system component</li>
</ul>
