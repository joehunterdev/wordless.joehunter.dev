# Meta System Plan

## Current State

Each content file declares a `$meta` array at the top:

```php
<?php $meta = [
    'title'       => 'Arquitectura y Características',
    'description' => 'Explora la arquitectura de Wordless CMS...',
    'date'        => '2026-05-05',
    'menu'        => ['order' => 3, 'title' => 'Features'],
]; ?>
```

`FileContentRepository::inheritedMeta()` already walks up the directory tree and merges
ancestor `index.php` meta arrays — innermost wins. `Content::get($key)` provides safe
access to any meta key.

### What's missing
- No `lang` / `locale` on individual pages (only on `en/index.php`, `es/index.php`)
- No `keywords` field at all
- `menu` nesting (`parent`, `order`) lives inline — no global defaults
- `head.php` ignores `description`, `keywords`, `lang`, `locale` entirely

---

## Proposed Meta Schema

Every content file can declare any subset of the following. Unset keys fall back to
inherited values from ancestor `index.php` files, then to global defaults.

```php
<?php $meta = [

    // ── Identity ──────────────────────────────────────────────────────────
    'title'       => 'Page Title',          // <title> + <h1> fallback
    'description' => 'One-line summary.',   // <meta name="description">
    'keywords'    => ['cms', 'php', 'flat-file'], // <meta name="keywords"> — array
    'date'        => '2026-05-05',          // ISO date string

    // ── Language ──────────────────────────────────────────────────────────
    'lang'        => 'en',                  // <html lang=""> — short code
    'locale'      => 'en-US',              // <meta property="og:locale">
    'dir'         => 'ltr',                // <html dir="">

    // ── Menu ──────────────────────────────────────────────────────────────
    'menu'        => [
        'title'   => 'Display Title',      // overrides 'title' in nav
        'order'   => 1,                    // sort position (lower = earlier)
        'parent'  => '/en/features',       // path of parent item → dropdown
    ],

    // ── SEO / Open Graph (future) ─────────────────────────────────────────
    'canonical'   => 'https://wordless.joehunter.dev/en/features',
    'og_image'    => '/assets/img/og-features.png',

]; ?>
```

---

## Inheritance Chain

```
content/index.php           (global defaults — lang, locale, site name)
  └── content/en/index.php  (language defaults — lang: en, locale: en-US)
        └── content/en/features/index.php  (section defaults)
              └── content/en/features/file-based-routing.php  (page — wins on conflict)
```

`FileContentRepository::inheritedMeta()` already implements this merge correctly.
No change needed to the repository layer.

---

## Changes Required

### 1. Global defaults in `config.php`

Add a `meta` key to config that acts as the outermost fallback:

```php
'meta' => [
    'lang'        => 'en',
    'locale'      => 'en-US',
    'dir'         => 'ltr',
    'keywords'    => ['wordless', 'cms', 'php'],
    'description' => 'A minimal flat-file CMS built with modern PHP.',
],
```

`FileContentRepository` merges config defaults → ancestor chain → page meta.

### 2. `head.php` — consume the new fields

```php
<html lang="<?= e($content->get('lang', 'en')) ?>" dir="<?= e($content->get('dir', 'ltr')) ?>">
<head>
    <meta name="description" content="<?= e($content->get('description', '')) ?>">
    <meta name="keywords"    content="<?= e(implode(', ', (array) $content->get('keywords', []))) ?>">
    <!-- og:locale, canonical etc. go here too -->
</head>
```

`head.php` currently only receives `$pageTitle`. It needs access to `$content` (or a
flat `$meta` array) passed from `page.php` → layout → partial.

### 3. `page.php` — pass meta to layout

```php
<?php
$layout    = 'base';
$pageTitle = $content->title;
$pageMeta  = $content->meta;   // ← add this
?>
```

`base.php` passes `$pageMeta` through to `head.php`.

### 4. `keywords` — array vs string

Store as array in content files, render as comma-joined string in `head.php`.
`Content::get('keywords', [])` always returns array; cast with `(array)` as safety net.

### 5. `lang` on `<html>` tag

Currently `base.php` has a static `<html>`. Change to:

```php
<html lang="<?= e($pageMeta['lang'] ?? 'en') ?>" dir="<?= e($pageMeta['dir'] ?? 'ltr') ?>">
```

This means Spanish pages automatically get `<html lang="es">` via inheritance from
`es/index.php` — no per-page declaration needed.

---

## Open Questions

1. **`keywords` — per-page or inherited only?**
   Should child pages merge their keywords with parent keywords (array union), or fully
   override? Recommendation: merge (array union), so section-level keywords propagate.

2. **`lang` switcher and `hreflang`**
   Should `head.php` emit `<link rel="alternate" hreflang="es" href="...">` tags?
   This needs the lang switcher logic to be accessible from the template layer.

3. **`canonical` URL**
   Auto-generate from current path + site base URL, or require explicit declaration?
   Auto-generation is simpler and correct in almost all cases.

4. **`og_image` fallback**
   Global default OG image in config, overridable per page?

5. **`date` rendering**
   Currently removed from `page.php`. Should it be available as `<meta>` only
   (for blog feeds/sitemaps), or also rendered visually on post-type pages?

---

## Implementation Order

1. Add `meta` defaults to `config.php`
2. Update `FileContentRepository` to merge config defaults into the base
3. Update `base.php` `<html>` tag to use `lang` / `dir`
4. Update `head.php` to output `description`, `keywords`, `lang`, `locale`
5. Update `page.php` to pass `$pageMeta` to layout
6. Add `keywords` to all content files (can be done incrementally)
7. Add `hreflang` alternate links (after lang switcher is stable)
