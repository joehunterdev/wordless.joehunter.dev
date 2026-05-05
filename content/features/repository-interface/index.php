<?php $meta = ['title' => 'Content Repository', 'date' => '2026-05-05']; ?>

<h1>Loading Content</h1>

<p>
    Wordless resolves pages directly from the <code>content/pages/</code> folder.
    The URL path maps 1-to-1 with the directory structure — no configuration required.
</p>

<h2>How it works</h2>
<ol>
    <li>A request hits <code>public/index.php</code></li>
    <li><code>Router</code> matches the path and hands it to <code>PageController</code></li>
    <li><code>FileContentRepository::find()</code> looks up the matching <code>.php</code> file</li>
    <li>The file is loaded, its output captured as <code>$body</code>, and a <code>Content</code> object returned</li>
    <li><code>PageController</code> passes the <code>Content</code> to the template renderer</li>
</ol>

<h2>URL → file resolution</h2>
<table>
    <thead>
        <tr><th>URL</th><th>File loaded</th></tr>
    </thead>
    <tbody>
        <?php foreach ([
            '/'                                  => 'content/pages/index.php',
            '/about'                             => 'content/pages/about.php',
            '/features'                          => 'content/pages/features/index.php',
            '/features/repository-interface'     => 'content/pages/features/repository-interface/index.php',
            '/en/about'                          => 'content/pages/en/about.php',
            '/es/algo'                           => 'content/pages/es/algo.php',
        ] as $url => $file): ?>
            <tr>
                <td><code><?= e($url) ?></code></td>
                <td><code><?= e($file) ?></code></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Content file format</h2>
<p>Each file declares an optional <code>$meta</code> array, then outputs HTML:</p>
<pre><code>&lt;?php $meta = ['title' =&gt; 'My Page', 'date' =&gt; '2026-05-05']; ?&gt;

&lt;h1&gt;My Page&lt;/h1&gt;
&lt;p&gt;Full PHP is available: &lt;?= date('Y') ?&gt;&lt;/p&gt;</code></pre>
