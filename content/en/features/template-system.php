<?php $meta = [
    'title'       => 'Template System',
    'description' => 'Pure PHP templates in Wordless: layouts, partials, and best practices for building reusable view components.',
    'date'        => '2026-05-05',
]; ?>

<h1>Template System</h1>

<p>
    Wordless uses pure PHP for templating, with no external templating engine.
    This means zero learning curve and full access to PHP's power when needed.
</p>

<h2>Why Pure PHP?</h2>

<p>
    Pure PHP templates offer several advantages:
</p>

<ul>
    <li><strong>No abstraction overhead:</strong> Write HTML and PHP directly</li>
    <li><strong>Full language features:</strong> Use any PHP function without restrictions</li>
    <li><strong>Fast performance:</strong> No compilation step or template parsing</li>
    <li><strong>Familiar syntax:</strong> Developers already know PHP</li>
    <li><strong>Zero dependencies:</strong> No additional libraries to install</li>
</ul>

<h2>Template Structure</h2>

<h3>Layouts</h3>

<p>
    Layouts wrap content pages with headers, footers, and navigation:
</p>

<pre><code>&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;?= $renderer-&gt;partial('head', ['pageTitle' =&gt; $pageTitle]) ?&gt;
&lt;body&gt;
    &lt;?= $renderer-&gt;partial('nav') ?&gt;
    &lt;main&gt;
        &lt;?= $slot ?&gt;
    &lt;/main&gt;
    &lt;?= $renderer-&gt;partial('footer') ?&gt;
&lt;/body&gt;
&lt;/html&gt;
</code></pre>

<h3>Partials</h3>

<p>
    Reusable components are stored as partials in <code>templates/partials/</code>:
</p>

<pre><code>templates/partials/
  head.php      → &lt;head&gt; with meta tags and CSS
  nav.php       → Navigation menu
  footer.php    → Site footer
</code></pre>

<h3>Content Pages</h3>

<p>
    Individual page templates render specific content:
</p>

<pre><code>&lt;?php
$layout    = 'base';              // Which layout to use
$pageTitle = $content-&gt;title;     // Pass data to layout
?&gt;

&lt;article&gt;
    &lt;h1&gt;&lt;?= e($content-&gt;title) ?&gt;&lt;/h1&gt;
    &lt;div class="body"&gt;
        &lt;?= $content-&gt;body ?&gt;
    &lt;/div&gt;
&lt;/article&gt;
</code></pre>

<h2>Output Escaping</h2>

<p>
    Always use the <code>e()</code> helper to escape user-controlled output:
</p>

<pre><code>&lt;!-- Safe --&gt;
&lt;h1&gt;&lt;?= e($title) ?&gt;&lt;/h1&gt;

&lt;!-- Unsafe --&gt;
&lt;h1&gt;&lt;?= $title ?&gt;&lt;/h1&gt;
</code></pre>

<p>
    The <code>e()</code> function uses <code>htmlspecialchars()</code> with strict flags to prevent XSS attacks.
</p>

<h2>Rendering Process</h2>

<p>
    When a page is requested:
</p>

<ol>
    <li>Content is loaded from the filesystem</li>
    <li>The page template renders the content</li>
    <li>If the template declares <code>$layout</code>, it's wrapped in that layout</li>
    <li>The final HTML is returned to the client</li>
</ol>

<h2>Accessing Data</h2>

<p>
    Templates receive data via variable injection:
</p>

<pre><code>// In your renderer
$renderer-&gt;render('page', [
    'content' =&gt; $contentObject,
    'related' =&gt; $relatedPages,
]);

// In the template
&lt;?php
$content-&gt;title;    // Available as $content
$related;           // Available as $related
$renderer;          // Always available
?&gt;
</code></pre>

<h2>Best Practices</h2>

<ul>
    <li><strong>Always escape output:</strong> Use <code>e()</code> for all user-controlled data</li>
    <li><strong>Keep logic minimal:</strong> Use templates for presentation, not business logic</li>
    <li><strong>Use semantic HTML:</strong> Structure for accessibility and SEO</li>
    <li><strong>Reuse partials:</strong> Create reusable components for common patterns</li>
    <li><strong>Separate concerns:</strong> Keep template markup away from PHP logic when possible</li>
</ul>

<p><a href="/en/features">← Back to Features</a></p>
