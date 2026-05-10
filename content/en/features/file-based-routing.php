<?php $meta = [
    'title'       => 'File-Based Routing',
    'description' => 'How Wordless maps URLs directly to the filesystem. No configuration, no route definitions — just pure directory conventions.',
    'menu'        => ['parent' => '/en/features', 'order' => 2],
    'keywords'    => ['routing', 'urls', 'filesystem', 'conventions', 'paths'],
]; ?>

<h1>File-Based Routing</h1>

<p>
    Wordless uses the filesystem as its source of truth for routing. Every URL path maps directly to a file or folder,
    eliminating the need for route configuration files and keeping your site structure transparent and intuitive.
</p>

<h2>Core Concept</h2>

<p>
    There is a 1-to-1 relationship between URLs and files:
</p>

<table>
    <thead>
        <tr><th>URL</th><th>File</th></tr>
    </thead>
    <tbody>
        <tr><td><code>/</code></td><td><code>content/index.php</code></td></tr>
        <tr><td><code>/about</code></td><td><code>content/about.php</code></td></tr>
        <tr><td><code>/blog/hello-world</code></td><td><code>content/blog/hello-world.php</code></td></tr>
        <tr><td><code>/features/file-based-routing</code></td><td><code>content/features/file-based-routing.php</code></td></tr>
    </tbody>
</table>

<h2>How Resolution Works</h2>

<p>
    When a request for <code>/blog/hello-world</code> arrives, the router:
</p>

<ol>
    <li>Checks for <code>content/blog/hello-world.php</code> (file match)</li>
    <li>If not found, checks for <code>content/blog/hello-world/index.php</code> (folder match)</li>
    <li>If still not found, returns a 404</li>
</ol>

<p>
    This allows both file-based and folder-based URLs to coexist naturally.
</p>

<h2>Advantages</h2>

<h3>No Configuration</h3>

<p>
    You don't need to define routes in a config file. The filesystem structure is the route definition.
    Add a file, and the URL exists immediately.
</p>

<h3>Transparency</h3>

<p>
    The site structure is visible in your editor's file tree. There's no hidden routing logic to decipher.
</p>

<h3>Flexibility</h3>

<p>
    You can use folders for logical grouping (<code>/blog/</code>), single files for simple pages (<code>/about.php</code>),
    or mix both in the same project.
</p>

<h3>SEO-Friendly</h3>

<p>
    Descriptive folder and file names become readable, keyword-rich URLs automatically.
</p>

<h2>Convention Over Configuration</h2>

<p>
    This pattern implements the "Convention over Configuration" principle:
    Instead of writing route definitions, you follow a simple convention (folder structure = URLs)
    and the system handles the rest.
</p>

<h2>Nested Routes</h2>

<p>
    Deep nesting works naturally:
</p>

<pre><code>content/
  docs/
    guides/
      getting-started.php     → /docs/guides/getting-started
      deployment.php          → /docs/guides/deployment
</code></pre>

<h2>Index Pages as Landing Pages</h2>

<p>
    Each folder can have an <code>index.php</code> that serves as the folder's landing page:
</p>

<pre><code>/blog                → content/blog/index.php (blog listing)
/blog/2026           → content/blog/2026/index.php (2026 archive)
/blog/hello-world    → content/blog/hello-world.php (specific post)
</code></pre>

<p><a href="<?= route('features', 'en') ?>">← Back to Features</a></p>
