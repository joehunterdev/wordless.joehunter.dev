# Wordless Manifesto

Wordless is a pure PHP, flat-file CMS that treats the filesystem as both content store and architecture.

It is designed to be read as much as it is used.

## What the codebase proves

The current implementation already shows the core idea clearly:

- `public/index.php` is the front controller
- `bootstrap/app.php` wires the application, repository, renderer, cache, router, plugins, and middleware
- content lives as PHP files under `content/`
- templates live in native PHP under `templates/`
- helpers like `cfg()`, `img()`, `route()`, `e()`, `normalize_path()`, `locale_from_path()`, and `relative_path()` keep templates readable
- locale-aware behavior is driven from config, content structure, and peer resolution rather than a translation framework

Wordless is not trying to hide its mechanics. It is trying to make them visible.

## Core belief

Structure defines behavior.

In Wordless:

- directories express hierarchy
- files express pages
- metadata expresses intent
- templates express presentation
- helpers express convention
- the request lifecycle stays explicit

The filesystem is not just where the content lives. It is where the system becomes understandable.

## What Wordless is

Wordless is an architecture-first content system for developers who prefer clarity over abstraction.

It is:

- **pure PHP** — no templating engine, no Composer dependency tree, no hidden view layer
- **flat-file** — content is stored as files, not rows
- **filesystem-native** — URLs, folders, and page structure are intentionally aligned
- **locale-aware** — English and Spanish are first-class content trees
- **helper-driven** — templates stay small because common work is centralized
- **middleware-friendly** — error and cache handling sit around the core request flow

The goal is not to be the largest CMS. The goal is to be the clearest expression of a CMS built with modern PHP and no unnecessary layers.

## Content as code

Content files are PHP files.

A content file can declare `$meta` and render body markup directly. That keeps page structure, metadata, and output close together without turning content into an opaque blob.

The current model does a few important things:

- metadata is declared in the page file itself
- parent folders can contribute inherited meta
- sibling locales can be linked through resolved peers
- root content can act as a language chooser while locale content powers the real pages

This keeps content easy to reason about without introducing a database, admin schema, or parsing layer.

## Routing and URLs

Wordless uses file-based routing.

A URL maps to content on disk, and the `route()` helper resolves URLs with the current locale rules in mind.

The current shape is deliberate:

- `/` is the splash / language entry page
- `/about` resolves from default-locale content
- `/en` and `/es` remain explicit locale roots
- nested paths like `/en/features/file-based-routing` and `/es/caracteristicas/enrutamiento-archivos` come from the folder structure

Routing is not invented in a config file. It is discovered from the content tree.

## Rendering

Wordless uses native PHP templates on purpose.

The renderer coordinates templates and partials; it does not replace PHP with another language.

That means:

- templates stay transparent
- logic remains explicit
- layouts are composed from PHP partials
- escaping is still available where needed
- metadata and page state are passed deliberately into the view layer

The current layout and partials make that visible:

- `templates/layouts/base.php` establishes the page shell
- `templates/partials/head.php` emits canonical and alternate links from resolved peer data
- `templates/partials/lang-switch.php` uses peer paths and locale config instead of hardcoded routes
- `templates/partials/nav.php` renders the site navigation as a shared structural element

## Helpers as a contract

The helper layer is part of the design, not an accidental convenience.

Current helpers include:

- `cfg()` for configuration access
- `img()` for public asset URLs
- `route()` for content-aware paths
- `e()` for safe HTML output
- `normalize_path()` for canonical path formatting
- `locale_from_path()` for locale detection
- `relative_path()` for filesystem-to-URL translation

This keeps templates expressive without making them noisy.

## Locale and peer structure

Wordless is built to be locale-aware without turning into a translation framework.

The current approach is structural:

- locales are configured in `config.php`
- the default locale is `en`
- the peer map resolves equivalent pages across locales
- file-level `$meta['peers']` can override generated matches
- the language switcher reflects actual content, not hardcoded assumptions

That means locale support is a first-class architecture concern, not a bolt-on feature.

## Request flow

The request lifecycle stays visible.

The current flow is simple and direct:

`Request → Router → Controller → Repository → Parser → Renderer → Response`

Around that core, Wordless keeps the concerns separated:

- the router resolves the path
- the content controller loads content and resolves peers
- the repository finds the page and applies inherited metadata
- the parser captures the page body and extracts `$meta`
- the renderer handles templates, partials, and menu output
- the sitemap controller can emit XML from the same content source

## Architecture boundaries

Wordless stays small by keeping responsibilities separate:

- the application kernel coordinates the request lifecycle
- the repository reads structured content from the filesystem
- the parser isolates body capture and meta extraction
- the renderer focuses on templates, layout, and menu generation
- middleware handles cross-cutting concerns like errors and cache
- content helpers keep common operations consistent
- optional extension points like plugins and events remain present without dominating the design

Each layer should do one job well.

## What Wordless is not

Wordless is not trying to be:

- a page builder
- a drag-and-drop abstraction layer
- a database-first CMS pretending to be lightweight
- a hidden framework wearing a CMS skin
- a system that requires guessing how it works

It is a deliberate system for people who want to see the mechanics.

## Design values

Wordless values:

- **clarity** over cleverness
- **explicitness** over magic
- **filesystem truth** over duplicated state
- **small abstractions** over large frameworks
- **testability** over convenience shortcuts
- **native PHP** over extra tooling
- **consistency** over feature bloat

The system should be understandable from the folder tree down to the rendered HTML.

## The ideal experience

A good Wordless project should feel like this:

- you add a file and it becomes a page
- you add a folder and it becomes structure
- you add metadata and the system understands intent
- you add a locale and the navigation and alternates follow it
- you reuse helpers and templates without losing visibility
- you can inspect the repository and understand the site

That is the point.

## The promise

Wordless exists to prove that a CMS can be simple without being shallow.

It can be:

- flat-file without being fragile
- pure PHP without being chaotic
- architecture-driven without being overengineered
- locale-aware without being verbose
- minimal without being forgettable

Wordless is a CMS where the structure is the message.

And the message is: keep it visible, keep it intentional, keep it Wordless.
