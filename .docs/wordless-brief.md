Good constraint set — this actually forces a *cleaner* design if you do it right.

You’ve basically got 3 problems to solve without a DB:

1. **Metadata storage**
2. **Hierarchy (parent / child pages)**
3. **Discoverability (listing subpages efficiently)**

Let’s go step by step in a way that stays **pure PHP, no composer, no parsing overhead, clean OOP**.

---

# 🧠 Core Idea

Since you're using **flat files + PHP**, the *filesystem itself becomes your database*.

So:

* **Directories = hierarchy**
* **Files = pages**
* **PHP arrays/objects = metadata**

---

# 📁 Recommended Structure

```id="9k3w6a"
/content
  /pages
    /about
      index.php
      team.php
    /blog
      index.php
      post-1.php
      post-2.php
```

👉 Key rule:

* `index.php` = the parent page
* other files = children

---

# 🧾 1. Metadata: Best Approach (Pure PHP)

Each file returns structured data:

```php id="9otj5c"
// /content/pages/about/index.php

return [
    'title' => 'About Us',
    'slug' => 'about',
    'template' => 'page',
    'meta' => [
        'description' => 'About our company',
    ],
];
```

Child page:

```php id="v21f7p"
// /content/pages/about/team.php

return [
    'title' => 'Our Team',
    'slug' => 'team',
    'template' => 'page',
];
```

👉 Why arrays?

* Fast
* Native
* No parsing
* No dependencies

---

# 🧱 2. Convert Arrays → Objects (Important)

Never use raw arrays in your app.

```php id="0izs95"
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

# 🏭 3. Page Factory

```php id="imkq6u"
class PageFactory
{
    public function create(string $file): Page
    {
        $data = (static fn ($f) => require $f)($file);

        return new Page(
            title: $data['title'] ?? 'Untitled',
            slug: $data['slug'] ?? basename($file, '.php'),
            path: $file,
            meta: $data['meta'] ?? [],
            template: $data['template'] ?? 'page'
        );
    }
}
```

👉 Pattern:

* **Factory**
* **Data validation layer**

---

# 🌳 4. Hierarchy (THIS is the key part)

You don’t store relationships.

👉 You **derive them from the filesystem**.

---

## Example Mapping

```
/about/index.php   → /about
/about/team.php    → /about/team
```

---

## Page Repository

```php id="5shnbl"
class PageRepository
{
    public function find(string $slug): ?Page
    {
        $file = CONTENT_PATH . '/pages/' . $slug . '.php';

        if (!file_exists($file)) {
            $file = CONTENT_PATH . '/pages/' . $slug . '/index.php';
        }

        if (!file_exists($file)) {
            return null;
        }

        return $this->factory->create($file);
    }
}
```

---

# 👨‍👩‍👧 5. Finding Subpages

This is your “no DB” replacement for queries.

```php id="4f1r9h"
class PageRepository
{
    public function children(string $slug): array
    {
        $dir = CONTENT_PATH . '/pages/' . $slug;

        if (!is_dir($dir)) {
            return [];
        }

        $files = glob($dir . '/*.php');

        return array_map(
            fn ($file) => $this->factory->create($file),
            array_filter($files, fn ($f) => basename($f) !== 'index.php')
        );
    }
}
```

---

# ⚡ 6. Performance (VERY IMPORTANT)

Filesystem scanning can get slow.

👉 So you add a **simple index cache**:

```php id="shw5b8"
// /storage/cache/pages.php

return [
    'about' => '/content/pages/about/index.php',
    'about/team' => '/content/pages/about/team.php',
];
```

---

## Index Builder

```php id="p4p11a"
class PageIndexer
{
    public function build(): array
    {
        // scan once, flatten structure
    }
}
```

👉 Run:

* On deploy
* Or manually via CLI

---

# 🧭 7. Optional: Folder Metadata (VERY CLEAN)

Add `_meta.php` per directory:

```php id="a6jzdb"
// /content/pages/blog/_meta.php

return [
    'title' => 'Blog',
    'layout' => 'blog',
];
```

👉 This lets you:

* Define parent settings
* Control listing behavior
* Add ordering rules

---

# 📊 8. Ordering Without DB

Inside `_meta.php`:

```php id="id34ea"
return [
    'order' => ['post-2', 'post-1'],
];
```

Then sort children accordingly.

---

# 🧩 9. URL Generation (Important)

Never hardcode URLs.

```php id="b6dkg7"
class UrlGenerator
{
    public function for(Page $page): string
    {
        return '/' . $page->slug;
    }
}
```

---

# 🔥 Design Patterns You’re Using

### Core

* **Repository** → fetch pages
* **Factory** → build objects
* **Value Object** → Page

### Structure

* **Convention over configuration**
* **Filesystem as database**

### Performance

* **Cache Aside**
* **Precomputed index**

---

# ⚠️ Pitfalls to Avoid

### ❌ Deep nested scanning on every request

→ Always cache index

### ❌ Logic inside content files

→ Keep them data-only

### ❌ Mixing rendering with metadata

→ Separate cleanly

---

# 🧠 Final Mental Model

Think of your CMS as:

> “A filesystem-powered graph of Page objects, indexed and cached, with metadata stored as native PHP arrays.”

---

# 💡 If You Want to Level This Up

Next steps I can show you:

* A **full working mini CMS (no dependencies)**
* A **page indexer implementation**
* A **clean plugin/hook system for this exact setup**
* Or how to add **multi-language support without a DB**

Just tell me 👍
