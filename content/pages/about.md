---
title: About Wordless
date: 2026-05-02
---

# About Wordless

Wordless is a minimal, dependency-free flat-file CMS built with modern PHP.

## Philosophy

- **No database** — content lives in Markdown files
- **No composer** — zero third-party dependencies
- **No magic** — clean, readable, testable code

## Architecture

The system follows strict separation of concerns:

- `app/Core` — container and application kernel
- `app/Content` — repository, parsers, value objects
- `app/Routing` — file-based URL resolution
- `app/Http` — request, response, controllers, middleware
- `app/Templating` — native PHP renderer
- `app/Cache` — flat-file cache with TTL
- `app/Events` — lightweight event dispatcher
- `app/Plugins` — plugin registration system

## Content Format

Write pages in Markdown with optional front matter:

```
---
title: My Page
date: 2026-01-01
---

# My Page

Content goes here.
```

Files in `/content/pages/` map directly to URLs.
