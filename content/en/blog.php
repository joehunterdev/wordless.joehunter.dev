<?php $meta = [
    'title'       => 'Blog',
    'description' => 'Articles and updates from the Wordless project — a pure PHP flat-file CMS.',
    'menu'        => ['order' => 4, 'title' => 'Blog'],
    'keywords'    => ['wordless', 'blog', 'php', 'cms', 'flat-file'],
]; ?>

<h1>Blog</h1>

<p>
    Blog posts live as PHP files under <code>content/en/blog/</code>.
    Each file becomes a URL automatically — no database entries, no admin interface required.
</p>

<p>No posts yet. Check back soon.</p>

<p><a href="<?= route('about', 'en') ?>">← About Wordless</a></p>
