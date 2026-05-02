<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Wordless') ?> &mdash; Wordless</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body { font-family: system-ui, sans-serif; max-width: 800px; margin: 0 auto; padding: 2rem 1rem; color: #222; line-height: 1.6; }
        a { color: #0066cc; }
        nav { margin-bottom: 2rem; border-bottom: 1px solid #eee; padding-bottom: 1rem; }
        nav a { margin-right: 1rem; text-decoration: none; font-weight: 500; }
        nav a:hover { text-decoration: underline; }
        pre { background: #f4f4f4; padding: 1rem; overflow-x: auto; border-radius: 4px; }
        code { background: #f4f4f4; padding: 0.2em 0.4em; border-radius: 3px; font-size: 0.9em; }
        pre code { background: none; padding: 0; }
        blockquote { border-left: 4px solid #ddd; margin: 0; padding-left: 1rem; color: #666; }
        footer { margin-top: 3rem; border-top: 1px solid #eee; padding-top: 1rem; font-size: 0.85rem; color: #888; }
    </style>
</head>
<body>
    <nav>
        <a href="/">Home</a>
        <a href="/about">About</a>
        <a href="/blog">Blog</a>
    </nav>
    <main>
        <?= $slot ?? '' ?>
    </main>
    <footer>
        <p>Powered by <strong>Wordless</strong> &mdash; pure PHP flat-file CMS</p>
    </footer>
</body>
</html>
