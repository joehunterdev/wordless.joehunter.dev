<?php $meta = [
    'title'       => 'Filesystem Architecture',
    'description' => 'Best practices for organizing content in Wordless: folder structure, naming conventions, and scalable patterns.',
    'menu'        => ['parent' => '/en/features', 'order' => 7],
    'keywords'    => ['architecture', 'filesystem', 'structure', 'organization', 'conventions'],
]; ?>

<h1>Filesystem Architecture</h1>

<p>
    Your content organization defines your site structure. This guide outlines best practices
    for building scalable, maintainable Wordless sites.
</p>

<h2>Project Structure</h2>

<pre><code>wordless-site/
  ├── public/              (webroot)
  │   ├── index.php        (entry point)
  │   ├── .htaccess        (routing rules)
  │   └── assets/
  │       ├── css/
  │       ├── js/
  │       └── img/
  ├── content/             (all site content)
  │   ├── index.php        (homepage)
  │   ├── about.php
  │   ├── en/              (English section)
  │   │   ├── index.php
  │   │   ├── features/
  │   │   └── blog/
  │   ├── es/              (Spanish section)
  │   │   ├── index.php
  │   │   └── blog/
  │   └── docs/            (documentation)
  ├── templates/           (view files)
  │   ├── layouts/
  │   │   └── base.php
  │   ├── partials/
  │   └── page.php
  ├── app/                 (application code)
  ├── bootstrap/           (initialization)
  └── storage/             (cache, logs)
</code></pre>

<h2>Naming Conventions</h2>

<h3>File Names</h3>

<p>
    Use lowercase, hyphenated names for all files:
</p>

<table>
    <thead>
        <tr><th>Good</th><th>Bad</th></tr>
    </thead>
    <tbody>
        <tr><td><code>getting-started.php</code></td><td><code>GettingStarted.php</code></td></tr>
        <tr><td><code>file-based-routing.php</code></td><td><code>file_based_routing.php</code></td></tr>
        <tr><td><code>hello-world.php</code></td><td><code>helloworld.php</code></td></tr>
    </tbody>
</table>

<h3>Folder Names</h3>

<p>
    Use lowercase, plural names for folders containing multiple items:
</p>

<table>
    <thead>
        <tr><th>Good</th><th>Bad</th></tr>
    </thead>
    <tbody>
        <tr><td><code>content/blog/</code></td><td><code>content/Blog/</code></td></tr>
        <tr><td><code>content/docs/guides/</code></td><td><code>content/Docs/Guide/</code></td></tr>
        <tr><td><code>content/en/features/</code></td><td><code>content/EN/Feature/</code></td></tr>
    </tbody>
</table>

<h2>Content Organization Patterns</h2>

<h3>Pattern 1: Section-Based Organization</h3>

<pre><code>content/
  en/
    blog/
      index.php          (listing page)
      post-one.php
      post-two.php
    docs/
      index.php
      getting-started.php
      deployment.php
</code></pre>

<p>
    Best for: Sites with clear sections (blog, documentation, resources).
</p>

<h3>Pattern 2: Date-Based Organization</h3>

<pre><code>content/
  blog/
    2026/
      index.php          (year archive)
      may/
        index.php        (month archive)
        05-hello-world.php
      june/
        12-new-features.php
</code></pre>

<p>
    Best for: High-volume blogs that need year/month/day organization.
</p>

<h3>Pattern 3: Flat Organization</h3>

<pre><code>content/
  index.php
  about.php
  contact.php
  privacy.php
  terms.php
</code></pre>

<p>
    Best for: Simple sites with a few pages.
</p>

<h3>Pattern 4: Hybrid Organization</h3>

<p>
    Mix patterns as your site grows:
</p>

<pre><code>content/
  index.php
  about.php
  en/
    features/
    blog/
  es/
    features/
    blog/
  docs/
    guides/
    api/
</code></pre>

<h2>Metadata Strategy</h2>

<h3>Always Define Title and Description</h3>

<p>
    These are critical for SEO and user experience:
</p>

<pre><code>&lt;?php $meta = [
    'title'       =&gt; 'Getting Started with Wordless',
    'description' =&gt; 'A complete guide to setting up your first Wordless site',
    'date'        =&gt; '2026-05-05',
]; ?&gt;
</code></pre>

<h3>Use Inheritance for Common Metadata</h3>

<p>
    Define metadata once in folder <code>index.php</code> files:
</p>

<pre><code>// content/blog/index.php
&lt;?php $meta = [
    'layout' =&gt; 'blog',
    'type'   =&gt; 'blog',
]; ?&gt;

// All blog posts automatically inherit these
</code></pre>

<h2>Scaling Strategies</h2>

<h3>For Growing Content</h3>

<p>
    As your site grows, move into folders and index pages:
</p>

<pre><code>// Before (simple)
content/guides/getting-started.php

// After (scalable)
content/guides/
  index.php (listing)
  getting-started/
    index.php
    installation.php
    configuration.php
</code></pre>

<h3>For Multiple Languages</h3>

<p>
    Keep language folders at the root for clarity:
</p>

<pre><code>content/
  en/  (all English content)
  es/  (all Spanish content)
  fr/  (all French content)
</code></pre>

<h3>For Multiple Sites</h3>

<p>
    If deploying multiple Wordless sites, keep them in separate folders or repositories.
</p>

<h2>Best Practices</h2>

<ul>
    <li><strong>Use descriptive names:</strong> Filenames should hint at content</li>
    <li><strong>Avoid deep nesting:</strong> 4-5 levels maximum keeps URLs readable</li>
    <li><strong>Use index.php for folders:</strong> Makes those URLs available</li>
    <li><strong>Group related content:</strong> Semantic folder names improve maintainability</li>
    <li><strong>Keep slugs consistent:</strong> Use the same slug across language variants</li>
    <li><strong>Version control everything:</strong> Content is code in Wordless</li>
</ul>

<h2>Performance Considerations</h2>

<ul>
    <li><strong>Filesystem is fast:</strong> PHP's file operations are optimized</li>
    <li><strong>Use caching middleware:</strong> Cache rendered pages to avoid repeated parsing</li>
    <li><strong>Minimize recursive scans:</strong> <code>all('path')</code> with a specific path is faster than <code>all()</code></li>
</ul>

<p><a href="/en/features">← Back to Features</a></p>
