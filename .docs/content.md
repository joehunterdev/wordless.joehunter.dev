# 🧱 Flat File PHP CMS (No Dependencies)

A minimal, modern, object-oriented flat-file CMS built with pure PHP.
No database. No Composer. No frameworks. Just clean architecture and the filesystem.

---

## ✨ Features

* 📂 Filesystem-based content (no database)
* ⚡ Fast and lightweight
* 🧠 Clean OOP architecture
* 🔌 Extensible (plugins/hooks ready)
* 🧾 Metadata via native PHP arrays
* 🌳 Automatic page hierarchy from directories
* 🧼 No global state, no magic

---

## 📁 Project Structure

```
/content
  /pages
    /about
      index.php
      team.php
    /blog
      index.php
      post-1.php

/core
  Application.php
  Router.php
  Page.php
  PageFactory.php
  PageRepository.php
  Renderer.php

/public
  index.php

/templates
  layout.php
  page.php

/storage
  /cache

/config
  app.php
```

---

## 🚀 How It Works

### 1. Routing

URLs map directly to files:

```
/about        → /content/pages/about/index.php
/about/team   → /content/pages/about/team.php
```

---

### 2. Content Files

Each page is a simple PHP file that returns structured data:

```php
<?php

return [
    'title' => 'About Us',
    'slug' => 'about',
    'template' => 'page',
    'meta' => [
        'description' => 'Learn more about us',
    ],
];
```

---

### 3. Page Hierarchy

Folders define relationships:

```
about/
  index.php   → parent page
  team.php    → child page
```

No need to manually define parent/child relationships.

---

### 4. Rendering Flow

```
Request → Router → PageRepository → PageFactory → Renderer → Response
```

---

## 🧾 Example Content

### `/content/pages/about/index.php`

```php
<?php

return [
    'title' => 'About Us',
    'slug' => 'about',
    'template' => 'page',
    'meta' => [
        'description' => 'About our company',
    ],
];
```

---

### `/content/pages/about/team.php`

```php
<?php

return [
    'title' => 'Our Team',
    'slug' => 'team',
    'template' => 'page',
    'meta' => [
        'description' => 'Meet the team',
    ],
];
```

---

### Optional: `/content/pages/about/_meta.php`

```php
<?php

return [
    'title' => 'About Section',
    'order' => ['team'],
];
```

---

## 🎨 Templates

### `/templates/layout.php`

```php
<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($page->title) ?></title>
</head>
<body>
    <?= $content ?>
</body>
</html>
```

---

### `/templates/page.php`

```php
<h1><?= htmlspecialchars($page->title) ?></h1>

<p><?= $page->meta['description'] ?? '' ?></p>
```

---

## 🧠 Core Concepts

### Page Object (Immutable)

```php
final class Page
{
    public function __construct(
        public readonly string $title,
        public readonly string $slug,
        public readonly string $path,
        public readonly array $meta = [],
        public readonly string $template = 'page'
    ) {}
}
```

---

### PageFactory

Responsible for turning raw PHP arrays into structured objects.

---

### PageRepository

Handles:

* Finding pages
* Resolving paths
* Fetching children

---

## 🌳 Getting Child Pages

Example usage:

```php
$children = $repository->children('about');
```

Returns all pages inside `/about/` except `index.php`.

---

## ⚡ Caching (Recommended)

To improve performance, generate a page index:

```php
return [
    'about' => '/content/pages/about/index.php',
    'about/team' => '/content/pages/about/team.php',
];
```

Store in:

```
/storage/cache/pages.php
```

---

## 🧩 Design Principles

* **Convention over configuration**
* **Filesystem = database**
* **Data (content) is separate from logic**
* **Immutable objects**
* **Single responsibility classes**

---

## ⚠️ Rules for Content Files

* Must return an array
* No business logic
* No service/container access
* Keep them simple and declarative

---

## 🔮 Future Ideas

* CLI index builder
* Plugin system (hooks/events)
* Static HTML cache
* Multi-language support
* Admin panel (optional)

---

## 🛠️ Run It

1. Point your server to `/public`
2. Open in browser
3. Done ✅

---

## 📌 Philosophy

> This CMS is designed to stay small, understandable, and predictable.
> If something feels "magical", it's probably wrong.

---

## 🤝 Contributing

Keep it simple. Keep it clean. No unnecessary abstractions.

---

## 📄 License

MIT (or whatever you prefer)

If you want, I can next generate:

* the actual **core PHP classes (ready to copy-paste)**
* a **minimal working version (~150–200 lines)**
* or a **dev-friendly CLI for rebuilding the cache/index**

Just tell me 👍
