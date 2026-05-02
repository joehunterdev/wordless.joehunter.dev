# Wordless CMS

A pure PHP flat-file CMS with zero dependencies (no Composer, no npm).

## Requirements

- PHP 8.1+
- Apache with `mod_rewrite` (or nginx equivalent)

## Setup

1. Point your web server's document root to `/public`
2. Ensure `/storage/cache` and `/storage/logs` are writable
3. Drop Markdown files into `/content/pages/` — they're live immediately

## Content

Write pages as Markdown files in `/content/pages/`:

```
/content/pages/index.md     → /
/content/pages/about.md     → /about
/content/pages/blog.md      → /blog
/content/pages/blog/post.md → /blog/post
```

Posts go in `/content/posts/`.

## Front Matter

```yaml
---
title: My Page
date: 2026-01-01
---

# My Page content here
```

## Structure

```
/app
  /Core          — Container, Application kernel
  /Content       — Repository, Content value object, Parsers
  /Routing       — Router
  /Http          — Request, Response, Controllers, Middleware
  /Templating    — Native PHP Renderer
  /Cache         — File-based cache
  /Events        — Event dispatcher
  /Plugins       — Plugin interface & manager
/bootstrap       — Autoloader, app bootstrap
/config          — app.php config
/content         — Markdown pages and posts
/public          — Web root (index.php, .htaccess)
/storage         — Cache and logs
/templates       — PHP templates and layouts
```
