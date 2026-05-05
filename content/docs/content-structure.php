<?php $meta = ['title' => 'Content Structure', 'date' => '2026-05-05']; ?>

<h1>Content Structure</h1>

<p>
    Wordless stores all content as plain PHP files in the <code>content/</code> directory.
    There is a direct 1-to-1 mapping between the filesystem and URLs — no configuration needed.
</p>

<h2>Directory Layout</h2>

<pre><code>content/
  index.php              → /
  about.php              → /about
  blog/
    index.php            → /blog
    hello-world.php      → /blog/hello-world
    2026/
      index.php          → /blog/2026
  features/
    index.php            → /features
    file-based-routing/
      index.php          → /features/file-based-routing
  es/
    index.php            → /es (language: es)
    algo.php             → /es/algo
    blog/
      index.php          → /es/blog
</code></pre>

<h2>URL Resolution</h2>

<table>
    <thead>
        <tr><th>URL</th><th>File</th></tr>
    </thead>
    <tbody>
        <tr>
            <td><code>/</code></td>
            <td><code>content/index.php</code></td>
        </tr>
        <tr>
            <td><code>/about</code></td>
            <td><code>content/about.php</code></td>
        </tr>
        <tr>
            <td><code>/blog</code></td>
            <td><code>content/blog/index.php</code></td>
        </tr>
        <tr>
            <td><code>/blog/hello-world</code></td>
            <td><code>content/blog/hello-world.php</code></td>
        </tr>
        <tr>
            <td><code>/es/algo</code></td>
            <td><code>content/es/algo.php</code></td>
        </tr>
    </tbody>
</table>

<h2>Content File Format</h2>

<p>Every content file is a PHP file that declares optional metadata and outputs HTML:</p>

<pre><code>&lt;?php $meta = [
    'title'       =&gt; 'My Page',
    'date'        =&gt; '2026-05-05',
    'description' =&gt; 'A brief description',
    'author'      =&gt; 'Joe Hunter',
]; ?&gt;

&lt;h1&gt;My Page&lt;/h1&gt;
&lt;p&gt;Content with full PHP support: &lt;?= date('Y') ?&gt;&lt;/p&gt;
</code></pre>

<h3>Supported Meta Fields</h3>

<table>
    <thead>
        <tr><th>Field</th><th>Type</th><th>Example</th></tr>
    </thead>
    <tbody>
        <tr>
            <td><code>title</code></td>
            <td>string</td>
            <td>About Us</td>
        </tr>
        <tr>
            <td><code>date</code></td>
            <td>string (YYYY-MM-DD)</td>
            <td>2026-05-05</td>
        </tr>
        <tr>
            <td><code>description</code></td>
            <td>string</td>
            <td>Page summary for SEO</td>
        </tr>
        <tr>
            <td><code>author</code></td>
            <td>string</td>
            <td>Joe Hunter</td>
        </tr>
        <tr>
            <td><code>language</code></td>
            <td>string (inherited)</td>
            <td>es</td>
        </tr>
        <tr>
            <td><code>custom</code></td>
            <td>any</td>
            <td>Your own fields</td>
        </tr>
    </tbody>
</table>

<h2>Inherited Metadata</h2>

<p>
    Child pages automatically inherit metadata from their parent's <code>index.php</code>.
    The child's own metadata takes precedence.
</p>

<h3>Example: Language Inheritance</h3>

<p><strong>File: <code>content/es/index.php</code></strong></p>

<pre><code>&lt;?php $meta = [
    'language' =&gt; 'es',
    'locale'   =&gt; 'es-ES',
    'dir'      =&gt; 'ltr',
]; ?&gt;

&lt;h1&gt;Español&lt;/h1&gt;
</code></pre>

<p><strong>File: <code>content/es/algo.php</code></strong></p>

<pre><code>&lt;?php $meta = ['title' =&gt; 'Algo']; ?&gt;

&lt;h1&gt;Algo&lt;/h1&gt;
</code></pre>

<p>When <code>/es/algo</code> is loaded, the metadata is merged:</p>

<pre><code>[
    'language'  =&gt; 'es',      (from /es/index.php)
    'locale'    =&gt; 'es-ES',   (from /es/index.php)
    'dir'       =&gt; 'ltr',     (from /es/index.php)
    'title'     =&gt; 'Algo',    (from /es/algo.php — wins!)
]
</code></pre>

<h3>Multi-Level Inheritance</h3>

<p>Nested folders can inherit from multiple ancestors:</p>

<pre><code>content/
  es/
    index.php          → language: es
    blog/
      index.php        → section: blog (inherits language: es)
      post.php         → title: Post (inherits language: es + section: blog)
</code></pre>

<h2>Template Access</h2>

<p>In your page template (<code>templates/page.php</code>), access metadata via <code>Content::get()</code>:</p>

<pre><code>&lt;?php if ($content-&gt;get('author')): ?&gt;
    &lt;p class="author"&gt;By &lt;?= e($content-&gt;get('author')) ?&gt;&lt;/p&gt;
&lt;?php endif; ?&gt;

&lt;?php if ($content-&gt;get('date')): ?&gt;
    &lt;time datetime="&lt;?= e($content-&gt;get('date')) ?&gt;"&gt;
        &lt;?= e($content-&gt;get('date')) ?&gt;
    &lt;/time&gt;
&lt;?php endif; ?&gt;
</code></pre>

<h2>Querying Content</h2>

<p>Fetch all content in a subfolder:</p>

<pre><code>&lt;?php
$repo  = $container-&gt;get(ContentRepositoryInterface::class);
$posts = $repo-&gt;all('blog');   // all files under /blog/

foreach ($posts as $post) {
    echo $post-&gt;title;
}
?&gt;
</code></pre>

<h2>Best Practices</h2>

<ul>
    <li><strong>Use descriptive filenames:</strong> <code>getting-started.php</code> not <code>gs.php</code></li>
    <li><strong>Organize by section:</strong> put related content in folders</li>
    <li><strong>Use <code>index.php</code> for landing pages:</strong> it serves both as a page and meta source for children</li>
    <li><strong>Always escape output:</strong> use <code>e($value)</code> to prevent XSS</li>
    <li><strong>Keep metadata lean:</strong> only store what you'll query or display</li>
    <li><strong>Use hyphens in filenames:</strong> <code>my-page.php</code> not <code>my_page.php</code></li>
</ul>

<h2>Special URLs</h2>

<ul>
    <li><code>/sitemap.xml</code> — automatically generated XML sitemap (read-only)</li>
    <li><code>/</code> — homepage, resolved from <code>content/index.php</code></li>
</ul>

<h2>What Files Are Ignored</h2>

<p>The following are skipped when scanning content:</p>

<ul>
    <li>Hidden files (starting with <code>.</code>)</li>
    <li>Non-PHP files</li>
    <li><code>_meta.php</code> (legacy, no longer used)</li>
</ul>
