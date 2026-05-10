<?php
/** @var string $pageTitle */
/** @var array  $pageMeta */
/** @var string $currentPath */
$pageMeta    = $pageMeta ?? [];
$currentPath = $currentPath ?? '';
$title       = $pageTitle !== '' ? e($pageTitle) . ' &mdash; ' : '';
$description = e($pageMeta['description'] ?? '');
$keywords    = e(implode(', ', (array) ($pageMeta['keywords'] ?? [])));
$author      = e($pageMeta['author'] ?? cfg('meta.author', 'Joe Hunter'));
$locale      = e($pageMeta['locale'] ?? 'en-US');
$lang        = $pageMeta['lang'] ?? 'en';
$peers       = $pageMeta['peers'] ?? [];

$siteUrl   = rtrim($pageMeta['site_url'] ?? '', '/');
$canonical = $siteUrl !== '' ? $siteUrl . $currentPath : '';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?>Wordless</title>
    <?php if ($description): ?>
    <meta name="description" content="<?= $description ?>">
    <?php endif; ?>
    <?php if ($keywords): ?>
    <meta name="keywords" content="<?= $keywords ?>">
    <?php endif; ?>
    <?php if ($author): ?>
    <meta name="author" content="<?= $author ?>">
    <meta property="article:author" content="<?= $author ?>">
    <?php endif; ?>
    <meta property="og:locale" content="<?= $locale ?>">
    <meta property="og:title" content="<?= $title ?>Wordless">
    <?php if ($description): ?>
    <meta property="og:description" content="<?= $description ?>">
    <?php endif; ?>
    <?php if ($canonical): ?>
    <link rel="canonical" href="<?= e($canonical) ?>">
    <?php endif; ?>
    <link rel="icon" href="<?= img('logo.png') ?>" type="image/png">
    <link rel="apple-touch-icon" href="<?= img('logo.png') ?>">
    <?php if ($canonical && !empty($peers)): ?>
    <link rel="alternate" hreflang="<?= e($lang) ?>" href="<?= e($canonical) ?>">
    <?php foreach ($peers as $peerLang => $peerPath): ?>
    <link rel="alternate" hreflang="<?= e($peerLang) ?>" href="<?= e($siteUrl . $peerPath) ?>">
    <?php endforeach; ?>
    <link rel="alternate" hreflang="x-default" href="<?= e($canonical) ?>">
    <?php endif; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,600;0,900;1,200&display=swap">
    <link rel="stylesheet" href="/assets/css/app.css">
    <script type="module" src="/assets/js/app.js"></script>
</head>
