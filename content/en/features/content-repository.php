<?php $meta = [
    'title'       => 'Content Repository',
    'description' => 'The Content Repository pattern in Wordless: structured loading, querying, and metadata inheritance for flat-file content.',
    'date'        => '2026-05-05',
    'menu'        => ['parent' => '/en/features', 'order' => 3],
]; ?>

<h1>Content Repository</h1>

<p>
    The Content Repository abstracts the details of loading and querying content files.
    It provides a clean interface for finding individual pages and listing all content in a section.
</p>

<blockquote>
    <p>The repository hides complexity. Your code just asks for content — it doesn't care where it lives.</p>
</blockquote>

<h2>What Is a Repository?</h2>

<p>
    A <dfn>repository</dfn> is a design pattern that acts as a middleman between your code and data storage.
    In Wordless, the repository hides the complexity of:
</p>

<ul>
    <li>Locating files in the filesystem</li>
    <li>Parsing PHP content files</li>
    <li>Extracting metadata</li>
    <li>Building structured <code>Content</code> objects</li>
</ul>

<h2>Core Methods</h2>

<h3>find()</h3>

<p>Retrieve a single page by its path:</p>

<pre><code>$repo = $container->get(ContentRepositoryInterface::class);
$page = $repo->find('/blog/hello-world');

if ($page) {
    echo $page->title;
    echo $page->body;
    echo $page->get('author');
}
</code></pre>

<h3>all()</h3>

<p>List all content in a section:</p>

<pre><code>// All content
$pages = $repo->all();

// Only blog posts
$posts = $repo->all('blog');
</code></pre>

<h2>Metadata Inheritance</h2>

<p>
    Child pages automatically inherit metadata from their parent <code>index.php</code>.
    Innermost metadata wins on conflict.
</p>

<table>
    <thead>
        <tr>
            <th>File</th>
            <th>Metadata</th>
            <th>Result</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><code>es/index.php</code></td>
            <td><code>language: es</code></td>
            <td>Inherited by children</td>
        </tr>
        <tr>
            <td><code>es/algo.php</code></td>
            <td><code>title: Algo</code></td>
            <td>Merged with parent</td>
        </tr>
    </tbody>
</table>

<h2>Content Objects</h2>

<p>The repository returns <code>Content</code> value objects:</p>

<dl>
    <dt><code>$content->title</code></dt>
    <dd>The page title extracted from metadata</dd>

    <dt><code>$content->body</code></dt>
    <dd>Rendered HTML body from the content file</dd>

    <dt><code>$content->slug</code></dt>
    <dd>URL slug, e.g. <samp>blog/hello-world</samp></dd>

    <dt><code>$content->get($key, $default)</code></dt>
    <dd>Safe accessor for any metadata value</dd>
</dl>

<h2>Why Use a Repository?</h2>

<ul>
    <li><strong>Abstraction</strong> — hide filesystem details behind a clean interface</li>
    <li><strong>Testability</strong> — easy to mock or swap implementations</li>
    <li><strong>Flexibility</strong> — change storage without changing calling code</li>
    <li><em>Single responsibility</em> — one place handles all content loading</li>
</ul>

<h2>Under the Hood</h2>

<ol>
    <li>Maps the requested path to candidate file locations</li>
    <li>Walks up the directory tree collecting <mark>inherited metadata</mark></li>
    <li>Loads and parses the content file</li>
    <li>Merges metadata — innermost wins</li>
    <li>Returns a structured <code>Content</code> object</li>
</ol>

<hr>

<p><a href="/en/features">← Back to Features</a></p>

<h2>Core Methods</h2>

<h3>find()</h3>

<p>
    Retrieve a single page by its path:
</p>

<pre><code>$repo = $container-&gt;get(ContentRepositoryInterface::class);
$page = $repo-&gt;find('/blog/hello-world');

if ($page) {
    echo $page-&gt;title;
    echo $page-&gt;body;
    echo $page-&gt;get('author');
}
</code></pre>

<h3>all()</h3>

<p>
    List all content in a section:
</p>

<pre><code>// All content
$pages = $repo-&gt;all();

// Only blog posts
$posts = $repo-&gt;all('blog');

// Only Spanish content
$spanish = $repo-&gt;all('es');
</code></pre>

<h2>Metadata Inheritance</h2>

<p>
    Child pages automatically inherit metadata from their parent's <code>index.php</code>.
</p>

<h3>Example</h3>

<pre><code>// content/es/index.php
$meta = [
    'language' =&gt; 'es',
    'locale'   =&gt; 'es-ES',
];

// content/es/algo.php
$meta = ['title' =&gt; 'Algo'];

// When loading /es/algo, metadata is merged:
// ['language' =&gt; 'es', 'locale' =&gt; 'es-ES', 'title' =&gt; 'Algo']
</code></pre>

<h2>Content Objects</h2>

<p>
    The repository returns <code>Content</code> objects with structured data:
</p>

<pre><code>$content-&gt;title    // Page title
$content-&gt;body     // Rendered HTML content
$content-&gt;slug     // URL slug (e.g., 'blog/hello-world')
$content-&gt;meta     // Array of all metadata
$content-&gt;get($key, $default) // Get specific metadata value
</code></pre>

<h2>Why Use a Repository?</h2>

<ul>
    <li><strong>Abstraction:</strong> Hide filesystem details behind a clean interface</li>
    <li><strong>Testability:</strong> Easy to mock or create test implementations</li>
    <li><strong>Flexibility:</strong> Swap implementations without changing calling code</li>
    <li><strong>Consistency:</strong> All content access goes through one path</li>
</ul>

<h2>Under the Hood</h2>

<p>
    The repository:
</p>

<ol>
    <li>Maps the requested path to potential file locations</li>
    <li>Walks up the directory tree collecting inherited metadata</li>
    <li>Loads and parses the content file</li>
    <li>Merges metadata with inheritance</li>
    <li>Returns a structured Content object</li>
</ol>

<p><a href="/en/features">← Back to Features</a></p>
