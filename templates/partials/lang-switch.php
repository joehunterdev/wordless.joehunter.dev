<?php
/** @var string $currentPath */
$currentPath = $currentPath ?? '';

// Detect current language from path prefix
if (str_starts_with($currentPath, '/es')) {
    $activeLang  = 'es';
    $altLang     = 'en';
    // Map known Spanish paths to their English equivalents
    $altPath = match(true) {
        $currentPath === '/es'                                      => '/',
        $currentPath === '/es/acerca'                               => '/about',
        $currentPath === '/es/blog'                                 => '/blog',
        str_starts_with($currentPath, '/es/caracteristicas')        => preg_replace('#^/es/caracteristicas#', '/en/features', $currentPath),
        default                                                     => preg_replace('#^/es#', '/en', $currentPath),
    };
    $altLabel    = 'EN';
    $activeLabel = 'ES';
} elseif (str_starts_with($currentPath, '/en')) {
    $activeLang  = 'en';
    $altLang     = 'es';
    $altPath = match(true) {
        str_starts_with($currentPath, '/en/features') => preg_replace('#^/en/features#', '/es/caracteristicas', $currentPath),
        default                                        => preg_replace('#^/en#', '/es', $currentPath),
    };
    $altLabel    = 'ES';
    $activeLabel = 'EN';
} else {
    // Root pages: /, /about, /blog → map to /es equivalents
    $activeLang  = 'en';
    $altLang     = 'es';
    $altPath = match($currentPath) {
        '/'      => '/es',
        '/about' => '/es/acerca',
        '/blog'  => '/es/blog',
        default  => '/es',
    };
    $altLabel    = 'ES';
    $activeLabel = 'EN';
}
?>
<div class="lang-switch">
    <span class="lang-switch__active"><?= $activeLabel ?></span>
    <span class="lang-switch__sep">|</span>
    <a href="<?= htmlspecialchars($altPath) ?>" class="lang-switch__alt"><?= $altLabel ?></a>
</div>
