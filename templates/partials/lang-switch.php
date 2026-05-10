<?php
/** @var array  $pageMeta */
/** @var string $currentPath */
$pageMeta = $pageMeta ?? [];
$lang     = $pageMeta['lang'] ?? 'en';
$peers    = $pageMeta['peers'] ?? [];
$locales  = cfg('locales', ['en']);

$altLang = null;
foreach ($locales as $locale) {
    if ($locale !== $lang) {
        $altLang = $locale;
        break;
    }
}
?>
<?php if ($altLang): ?>
<div class="lang-switch">
    <span class="lang-switch__active"><?= e(strtoupper($lang)) ?></span>
    <span class="lang-switch__sep">|</span>
    <a href="<?= e($peers[$altLang] ?? '/' . $altLang) ?>" class="lang-switch__alt"><?= e(strtoupper($altLang)) ?></a>
</div>
<?php endif; ?>
