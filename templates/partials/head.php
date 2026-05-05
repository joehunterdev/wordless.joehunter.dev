<?php
/** @var string $pageTitle */
$title = $pageTitle !== '' ? htmlspecialchars($pageTitle) . ' &mdash; ' : '';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?>Wordless</title>
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
        table { border-collapse: collapse; width: 100%; margin: 1rem 0; }
        th, td { border: 1px solid #ddd; padding: 0.5rem 0.75rem; text-align: left; }
        th { background: #f4f4f4; }
        blockquote { border-left: 4px solid #ddd; margin: 0; padding-left: 1rem; color: #666; }
    </style>
</head>
