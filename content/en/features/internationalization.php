<?php $meta = [
    'title'       => 'Internationalization',
    'description' => 'Multi-language support in Wordless: organize content by language, inherit locale metadata, and scale globally.',
    'menu'        => ['order' => 6],
    'keywords'    => ['i18n', 'internationalization', 'languages', 'localization', 'multilingual'],
]; ?>

<h1>Internationalization (i18n)</h1>

<p>
    Wordless handles multiple languages through a clean, directory-based approach.
    Each language lives in its own folder, and content automatically inherits language metadata.
</p>

<h2>Directory Structure</h2>

<pre><code>content/
  en/
    index.php              → /en
    about.php              → /en/about
    blog/
      index.php            → /en/blog
      post.php             → /en/blog/post

  es/
    index.php              → /es
    about.php              → /es/about
    blog/
      index.php            → /es/blog
</code></pre>

<h2>Language Inheritance</h2>

<p>
    Each language folder's <code>index.php</code> declares metadata inherited by all child pages:
</p>

<pre><code>&lt;?php $meta = [
    'language' =&gt; 'es',
    'locale'   =&gt; 'es-ES',
    'dir'      =&gt; 'ltr',
]; ?&gt;

&lt;h1&gt;Español&lt;/h1&gt;
</code></pre>

<p>
    Every page under <code>/es/</code> automatically inherits <code>language: 'es'</code>,
    but can override other metadata:
</p>

<pre><code>&lt;?php $meta = [
    'title' =&gt; 'Acerca de',
    'date'  =&gt; '2026-05-05',
]; ?&gt;

&lt;h1&gt;Acerca de Wordless&lt;/h1&gt;
</code></pre>

<h2>Using Locale Data in Templates</h2>

<p>
    Access language information in your templates:
</p>

<pre><code>&lt;html lang="&lt;?= e($content-&gt;get('locale', 'en-US')) ?&gt;"&gt;

&lt;?php if ($content-&gt;get('language') === 'ar'): ?&gt;
    &lt;!-- Right-to-left styles for Arabic --&gt;
&lt;?php endif; ?&gt;
</code></pre>

<h2>Querying Language-Specific Content</h2>

<p>
    Fetch all content in a specific language:
</p>

<pre><code>$repo = $container-&gt;get(ContentRepositoryInterface::class);

// All Spanish pages
$spanish = $repo-&gt;all('es');

// All English blog posts
$englishBlog = $repo-&gt;all('en/blog');

foreach ($spanish as $page) {
    echo $page-&gt;get('language'); // 'es'
}
</code></pre>

<h2>Language Switching Navigation</h2>

<p>
    Build language switchers by deriving alternate URLs:
</p>

<pre><code>&lt;?php
$currentLanguage = $content-&gt;get('language', 'en');
$availableLanguages = ['en', 'es', 'fr'];

foreach ($availableLanguages as $lang) {
    $altPath = '/' . $lang . $content-&gt;slug;
    $class = $lang === $currentLanguage ? 'active' : '';
    echo "&lt;a href='{$altPath}' class='{$class}'&gt;{$lang}&lt;/a&gt;";
}
?&gt;
</code></pre>

<h2>SEO Considerations</h2>

<h3>Language Meta Tag</h3>

<p>
    Always set the <code>lang</code> attribute on the <code>&lt;html&gt;</code> element:
</p>

<pre><code>&lt;html lang="&lt;?= e($content-&gt;get('locale')) ?&gt;"&gt;
</code></pre>

<h3>Alternate Links</h3>

<p>
    Help search engines understand language variations with <code>hreflang</code> links:
</p>

<pre><code>&lt;link rel="alternate" hreflang="es" href="/es/about" /&gt;
&lt;link rel="alternate" hreflang="en" href="/en/about" /&gt;
</code></pre>

<h3>Sitemaps</h3>

<p>
    The automatic sitemap includes all language variants, helping search engines discover them all.
</p>

<h2>Scaling to More Languages</h2>

<p>
    Adding a new language is as simple as creating a new folder:
</p>

<pre><code>mkdir content/fr
echo '&lt;?php $meta = ["language" =&gt; "fr", "locale" =&gt; "fr-FR"]; ?&gt;' &gt; content/fr/index.php
</code></pre>

<p>
    All French content now inherits the language metadata automatically.
</p>

<h2>Best Practices</h2>

<ul>
    <li><strong>Use BCP 47 locale codes:</strong> <code>en-US</code>, <code>es-ES</code>, <code>fr-FR</code></li>
    <li><strong>Organize by language first:</strong> Makes permissions and deployment easier</li>
    <li><strong>Keep slugs consistent:</strong> <code>/en/about</code> and <code>/es/about</code> use the same slug</li>
    <li><strong>Translate all navigation:</strong> Link switchers and menus for every language</li>
    <li><strong>Maintain parity:</strong> Keep content across languages reasonably synchronized</li>
</ul>

<p><a href="<?= route('features', 'en') ?>">← Back to Features</a></p>
