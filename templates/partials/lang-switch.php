<?php
/** @var string $currentPath */
$currentPath = $currentPath ?? '';

// Detect current language from path prefix
if (str_starts_with($currentPath, '/es')) {
    $activeLang  = 'es';
    $altLang     = 'en';
    $altPath = match(true) {
        $currentPath === '/es'                               => '/en',
        $currentPath === '/es/acerca'                        => '/en/about',
        $currentPath === '/es/blog'                          => '/en/blog',
        str_starts_with($currentPath, '/es/caracteristicas') => preg_replace('#^/es/caracteristicas#', '/en/features', $currentPath),
        default                                              => preg_replace('#^/es#', '/en', $currentPath),
    };
    $altLabel    = 'EN';
    $activeLabel = 'ES';
} elseif (str_starts_with($currentPath, '/en')) {
    $activeLang  = 'en';
    $altLang     = 'es';
    $altPath = match(true) {
        $currentPath === '/en'                          => '/es',
        $currentPath === '/en/about'                    => '/es/acerca',
        $currentPath === '/en/blog'                     => '/es/blog',
        str_starts_with($currentPath, '/en/features')   => preg_replace('#^/en/features#', '/es/caracteristicas', $currentPath),
        default                                         => preg_replace('#^/en#', '/es', $currentPath),
    };
    $altLabel    = 'ES';
    $activeLabel = 'EN';
} else {
    // Root page — offer both languages
    $activeLang  = 'en';
    $altLang     = 'es';
    $altPath     = '/es';
    $altLabel    = 'ES';
    $activeLabel = 'EN';
}
?>
<div class="lang-switch">
    <span class="lang-switch__active"><?= $activeLabel ?></span>
    <span class="lang-switch__sep">|</span>
    <a href="<?= htmlspecialchars($altPath) ?>" class="lang-switch__alt"><?= $altLabel ?></a>
</div>
