<?php
/** @var string $pageTitle */
/** @var array  $pageMeta */
/** @var string $currentPath */
$pageMeta    = $pageMeta ?? [];
$currentPath = $currentPath ?? '';
$title       = $pageTitle !== '' ? e($pageTitle) . ' &mdash; ' : '';
$description = e($pageMeta['description'] ?? '');
$keywords    = e(implode(', ', (array) ($pageMeta['keywords'] ?? [])));
$locale      = e($pageMeta['locale'] ?? 'en-US');
$lang        = $pageMeta['lang'] ?? 'en';

// Canonical URL (auto-generated)
$siteUrl   = rtrim($pageMeta['site_url'] ?? '', '/');
$canonical = $siteUrl !== '' ? $siteUrl . $currentPath : '';

// hreflang alternate
$altLang = null;
$altHref = null;
if ($siteUrl !== '') {
    //TODO: refactor this to be more data-driven and less hardcoded
    if (str_starts_with($currentPath, '/es')) {
        $altLang = 'en';
        $altPath = match(true) {
            $currentPath === '/es'                               => '/en',
            $currentPath === '/es/acerca'                        => '/en/about',
            $currentPath === '/es/blog'                          => '/en/blog',
            str_starts_with($currentPath, '/es/caracteristicas') => preg_replace('#^/es/caracteristicas#', '/en/features', $currentPath),
            default                                              => preg_replace('#^/es#', '/en', $currentPath),
        };
        $altHref = $siteUrl . $altPath;
    } elseif (str_starts_with($currentPath, '/en')) {
        $altLang = 'es';
        $altPath = match(true) {
            $currentPath === '/en'                          => '/es',
            $currentPath === '/en/about'                    => '/es/acerca',
            $currentPath === '/en/blog'                     => '/es/blog',
            str_starts_with($currentPath, '/en/features')   => preg_replace('#^/en/features#', '/es/caracteristicas', $currentPath),
            default                                         => preg_replace('#^/en#', '/es', $currentPath),
        };
        $altHref = $siteUrl . $altPath;
    } else {
        $altLang = 'es';
        $altPath = '/es';
        $altHref = $siteUrl . $altPath;
    }
}
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
    <meta property="og:locale" content="<?= $locale ?>">
    <meta property="og:title" content="<?= $title ?>Wordless">
    <?php if ($description): ?>
    <meta property="og:description" content="<?= $description ?>">
    <?php endif; ?>
    <?php if ($canonical): ?>
    <link rel="canonical" href="<?= e($canonical) ?>">
    <?php endif; ?>
    <?php if ($altLang && $altHref): ?>
    <link rel="alternate" hreflang="<?= e($lang) ?>" href="<?= e($canonical) ?>">
    <link rel="alternate" hreflang="<?= e($altLang) ?>" href="<?= e($altHref) ?>">
    <link rel="alternate" hreflang="x-default" href="<?= e($canonical) ?>">
    <?php endif; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,600;0,900;1,200&display=swap">
    <link rel="stylesheet" href="/assets/css/app.css">
    <script type="module" src="/assets/js/app.js"></script>
</head>
