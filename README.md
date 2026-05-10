# Wordless CMS

Wordless is a pure PHP, flat-file CMS that uses the filesystem as both content store and architecture.

It keeps the request flow explicit, the templates native, and the content structure readable from the repository itself.

## Highlights

- Pure PHP, no Composer, no npm
- File-based routing from content paths
- Native PHP templates and partials
- Locale-aware content with peer resolution
- Helper-driven templates: `cfg()`, `img()`, `route()`, `e()`
- File-based cache, middleware, sitemap, and plugin hooks

## Requirements

- PHP 8.1+
- Apache with `mod_rewrite` or nginx equivalent

## Setup

1. Point your web server document root to `/public`
2. Ensure `/storage/cache` and `/storage/logs` are writable
3. Adjust `config.php` for your local locale, site URL, and debug settings
4. Open the site — content is rendered directly from PHP files under `/content`

## How it works

Wordless boots through `public/index.php`, which loads `bootstrap/app.php` and hands the request to the application kernel.

From there:

`Request → Router → Controller → Content Repository → Parser → Renderer → Response`

The current codebase uses:

- `app/Core` for the application kernel and container
- `app/Content` for content loading, content objects, and peer maps
- `app/Routing` for file-based route resolution
- `app/Http` for request/response objects, controllers, and middleware
- `app/Templating` for PHP template rendering and navigation
- `app/Cache` for file-based caching
- `app/Events` and `app/Plugins` as extension points

## Content model

Content lives in PHP files under `/content`.

- Each page can declare `$meta` at the top of the file
- Content bodies are rendered as normal PHP/HTML
- Nested folders express hierarchy
- `index.php` represents a section root
- `inheritedMeta()` allows parent folder metadata to cascade to children

Examples:

```
/content/index.php                      → / (language splash)
/content/en/index.php                   → /en
/content/en/about.php                   → /about
/content/en/features/file-based-routing.php → /features/file-based-routing
/content/es/acerca.php                  → /es/acerca
/content/es/caracteristicas/index.php   → /es/caracteristicas
```

## Locale behavior

Locales are configured in `config.php` and loaded into the repository and peer map at bootstrap.

- Default locale: `en`
- Additional locale(s): `es`
- `content/en/*` pages resolve without a locale prefix for the default language
- `content/es/*` pages keep the locale prefix in the URL
- `PeerMap` resolves alternate-language peers for the language switcher and `hreflang` tags

## Templates and helpers

Templates are plain PHP and live in `/templates`.

Common helpers:

- `cfg()` reads config values with dot notation
- `img()` resolves public image assets
- `route()` generates content-aware URLs
- `e()` escapes output safely

The main layout is `templates/layouts/base.php`, which composes partials like `head`, `nav`, `lang-switch`, and `footer`.

## Routes and special pages

- `/` serves the splash / language selector page
- `/sitemap.xml` is handled by `SitemapController`
- Navigation is generated from content metadata rather than hardcoded menus
- Alternate language links are resolved from peer data, not manually duplicated paths

## Project structure

```
/app
  /Cache            — file-based cache
  /Config           — default config values
  /Content          — content repository, peer map, parser
  /Core             — application kernel and container
  /Events           — event dispatcher
  /Http             — request/response, controllers, middleware
  /Plugins          — plugin interface and manager
  /Routing          — router
  /Templating       — renderer and menu generation
/bootstrap          — app bootstrap and autoloader
/content            — PHP content files
/public             — web root and assets
/storage            — cache and logs
/templates          — layouts and partials
```

## Philosophy

Wordless is built on a few simple ideas:

- structure defines behavior
- the filesystem is the source of truth
- explicit code is easier to trust
- native PHP is enough when the boundaries are clean
- small abstractions are better than hidden magic

The goal is not to be the biggest CMS. The goal is to be the clearest one.

## Example URLs

```
/                         → splash / language selector
/en                       → English homepage
/about                    → English about page
/features/file-based-routing → English feature page
/es                       → Spanish homepage
/es/acerca                → Spanish about page
/es/caracteristicas       → Spanish features index
```

## Notes

- The homepage splash at `/content/index.php` is intentionally separate from locale content
- The repository skips redirect shims when scanning content
- Sitemap entries are generated from the current content tree
- Debug output should stay out of templates and renderers unless explicitly needed
