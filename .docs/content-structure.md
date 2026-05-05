# Wordless CMS — Architecture & Patterns

Wordless is a flat-file CMS built with pure PHP, no external dependencies, and a strong focus on clarity, simplicity, and architectural discipline.

This document outlines the core patterns and principles used throughout the system.

---

# 🧠 Philosophy

Wordless is built on a few key ideas:

* The filesystem is the source of truth
* Structure defines behavior
* Simplicity over abstraction
* No hidden magic
* Pure PHP as a first-class templating language

---

# 🧱 Core Architecture

## Front Controller

All requests enter through a single entry point:

```
/public/index.php
```

This file bootstraps the application and delegates handling to the core system.

**Why it matters:**

* Centralized control
* Predictable request lifecycle

---

## Application Kernel

The `Application` class acts as the core of the system.

```php
$app = new Application();
$app->handle($request);
```

Responsibilities:

* Bootstrapping
* Coordinating components
* Returning responses

**Pattern:**

* Application Kernel

---

## Dependency Injection (Manual)

Dependencies are passed explicitly instead of using a container.

```php
$router = new Router();
$repository = new FileContentRepository();
$app = new Application($router, $repository);
```

**Why:**

* Explicit dependencies
* No hidden state
* Easier to reason about

**Pattern:**

* Dependency Injection (manual)

---

# 🌐 Routing

## File-Based Routing

Routes are derived directly from the filesystem.

```
/en/features/file-based-routing → /public/en/features/file-based-routing/index.php
```

There are:

* no route definitions
* no configuration files

**Pattern:**

* Convention over Configuration

---

## Router Responsibility

The Router:

* Parses the URL
* Resolves directory paths
* Locates the correct content file

**Principle:**

* Single Responsibility

---

# 📦 Content Layer

## Repository Pattern

Content is loaded through a repository:

```php
$content = $repository->find($path);
```

The repository:

* Reads PHP files
* Normalizes data
* Returns structured objects

**Pattern:**

* Repository

---

## Content as Value Object

Each page becomes a structured object:

```php
[
    'title' => '...',
    'meta' => [...],
    'content' => fn () => ...
]
```

This is treated as immutable.

**Pattern:**

* Value Object

---

## Data Mapping

Content files return arrays that are mapped into structured data.

**Pattern:**

* Data Mapper (lightweight)

---

## Filesystem as Database

The filesystem replaces a traditional database.

**Advantages:**

* No setup required
* Fully transparent
* Version-controlled content

---

# 🎨 Rendering Layer

## Native PHP Templates

Templates are written in plain PHP:

```php
<?= $content['title'] ?>
```

No templating engine is used.

**Why:**

* Zero abstraction overhead
* Full flexibility
* Native performance

---

## Strategy Pattern (Rendering)

Rendering can be swapped or extended:

* Layout-based rendering
* Direct rendering
* JSON output (future)

**Pattern:**

* Strategy

---

## Template Method (Optional)

If rendering follows a defined sequence:

```
load layout → inject content → output
```

Then the system follows:

**Pattern:**

* Template Method

---

## View Model (Optional)

Structured data can be passed into templates instead of raw arrays.

---

# 🔁 Request Lifecycle

A request flows through the system like this:

```
Request
  → Router
  → Content Repository
  → Renderer
  → Response
```

---

## Middleware (Conceptual)

Even without a formal middleware system, the pipeline supports:

* Language detection
* 404 handling
* Future extensions

**Pattern:**

* Middleware (lightweight)

---

# 🌍 Internationalization

Content is organized by language:

```
/public/en/
/public/es/
```

---

## Language as Structure

Language is part of the URL and directory structure.

```
/en/about
/es/sobre
```

---

## Fallback Strategy (Optional)

If content does not exist in one language:

```
/es/page → fallback to /en/page
```

**Pattern:**

* Strategy

---

# 🧩 Filesystem Architecture

## Directory-as-Context

Each folder represents:

* A URL segment
* A content scope
* A logical grouping

```
/features/
    /file-based-routing/
    /content-repository/
```

This creates a natural hierarchy.

---

## Predictable Structure

There is a 1:1 relationship between:

* URL
* Folder
* Content file

---

# 🧠 Principles

## Convention over Configuration

No configuration files are needed.

Structure defines behavior.

---

## Separation of Concerns

Each component has a clear responsibility:

* Router → routing
* Repository → content loading
* Renderer → output

---

## Simplicity First

The system avoids:

* unnecessary abstraction
* external dependencies
* complex configuration

---

# 🔍 Summary of Patterns

| Area         | Patterns Used                         |
| ------------ | ------------------------------------- |
| Core         | Front Controller, Application Kernel  |
| Architecture | Dependency Injection                  |
| Routing      | Convention over Configuration         |
| Content      | Repository, Value Object, Data Mapper |
| Rendering    | Strategy, Template Method             |
| Request Flow | Middleware (conceptual)               |
| i18n         | Strategy (fallback)                   |
| Filesystem   | Directory-as-Context (custom)         |

---

# 🚀 Final Thoughts

Wordless demonstrates that a modern, structured system can be built using:

* pure PHP
* clear conventions
* well-understood design patterns

Without relying on frameworks or external tools.

It is both a CMS and a demonstration of architectural thinking.
