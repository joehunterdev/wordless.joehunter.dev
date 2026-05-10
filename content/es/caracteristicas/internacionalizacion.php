<?php $meta = [
    'title'       => 'Internacionalización',
    'description' => 'Soporte multilingüe en Wordless mediante estructura de directorios — sin plugins, sin configuración compleja.',
    'menu'        => ['parent' => '/es/caracteristicas', 'order' => 6],
    'keywords'    => ['i18n', 'internacionalización', 'idiomas', 'localización', 'multilingüe'],
]; ?>

<h1>Internacionalización</h1>

<p>
    Wordless soporta múltiples idiomas de forma natural a través de la estructura de directorios.
    No se necesitan plugins ni configuración compleja — solo carpetas.
</p>

<blockquote>
    <p>Si el enrutamiento sigue al sistema de archivos, los idiomas también lo hacen.</p>
</blockquote>

<h2>Estructura de Directorios</h2>

<pre><code>content/
  en/
    index.php         → /en
    features/
      index.php       → /en/features
      routing.php     → /en/features/routing
  es/
    index.php         → /es
    features/
      index.php       → /es/features
      enrutamiento.php → /es/features/enrutamiento
</code></pre>

<h2>Metadatos de Idioma</h2>

<p>
    Cada directorio de idioma tiene un <code>index.php</code> con metadatos de idioma
    que heredan todas las páginas hijas:
</p>

<pre><code>&lt;?php $meta = [
    'language' =&gt; 'es',
    'locale'   =&gt; 'es-ES',
    'dir'      =&gt; 'ltr',
]; ?&gt;
</code></pre>

<h2>Selector de Idioma</h2>

<p>
    El selector de idioma detecta el idioma actual a partir de la ruta URL
    y ofrece un enlace a la página equivalente en el otro idioma:
</p>

<table>
    <thead>
        <tr><th>Ruta actual</th><th>Enlace alternativo</th></tr>
    </thead>
    <tbody>
        <tr><td><code>/en/features</code></td><td><code>/es/features</code></td></tr>
        <tr><td><code>/en/features/routing</code></td><td><code>/es/features/routing</code></td></tr>
        <tr><td><code>/es/features</code></td><td><code>/en/features</code></td></tr>
    </tbody>
</table>

<h2>Ventajas del Enfoque</h2>

<ul>
    <li><strong>Sin dependencias</strong> — el sistema de archivos hace el trabajo</li>
    <li><strong>Herencia de metadatos</strong> — el idioma se hereda automáticamente de la carpeta padre</li>
    <li><strong>URLs limpias</strong> — <code>/es/features</code> en lugar de <code>/?lang=es&page=features</code></li>
    <li><em>Escalable</em> — añadir un nuevo idioma es tan simple como crear una nueva carpeta</li>
</ul>

<hr>

<p><a href="<?= route('caracteristicas', 'es') ?>">← Volver a Características</a></p>
