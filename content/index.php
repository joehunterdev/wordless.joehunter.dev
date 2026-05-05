<?php $meta = ['title' => 'Home', 'date' => '2026-05-05']; ?>

<h1>Welcome to Wordless</h1>

<p>A <strong>pure PHP</strong> flat-file CMS with zero dependencies.</p>

<h2>Features</h2>
<ul>
    <?php foreach ([
        'File-based routing',
        'PHP or Markdown content',
        'Native PHP templates',
        'File-based caching',
        'Plugin & event system',
    ] as $feature): ?>
        <li><?= htmlspecialchars($feature) ?></li>
    <?php endforeach; ?>
</ul>

<blockquote>
    <p>No database. No Composer. No magic.</p>
</blockquote>

<p><a href="/about">Read more about the project →</a></p>
