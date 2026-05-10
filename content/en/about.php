<?php $meta = [
    'title'    => 'About',
    'peers'    => ['es' => '/es/acerca'],
    'menu'     => ['order' => 2, 'title' => 'About'],
    'keywords' => ['wordless', 'about', 'philosophy', 'architecture', 'cms'],
]; ?>

<h1>About Wordless</h1>

<p>Wordless is a minimal, dependency-free flat-file CMS built with modern PHP.</p>

<h2>Philosophy</h2>
<ul>
    <?php foreach ([
        'No database — content lives in PHP files',
        'No Composer — zero third-party dependencies',
        'No magic — clean, readable, testable code',
    ] as $point): ?>
        <li><?= e($point) ?></li>
    <?php endforeach; ?>
</ul>

<h2>Architecture</h2>
<p>Strict separation of concerns across focused modules:</p>
<ul>
    <li><code>app/Core</code> — Container and Application kernel</li>
    <li><code>app/Content</code> — Repository and PHP file loader</li>
    <li><code>app/Routing</code> — File-based URL resolution</li>
    <li><code>app/Http</code> — Request, Response, Controllers, Middleware</li>
    <li><code>app/Templating</code> — Native PHP renderer with layouts</li>
    <li><code>app/Cache</code> — Flat-file cache with TTL</li>
    <li><code>app/Events</code> — Lightweight event dispatcher</li>
    <li><code>app/Plugins</code> — Plugin registration system</li>
</ul>

<p><a href="/en">← Back home</a></p>
