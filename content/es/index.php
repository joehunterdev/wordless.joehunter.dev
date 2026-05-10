<?php $meta = [
    'title'    => 'Inicio',
    'lang'     => 'es',
    'locale'   => 'es-ES',
    'dir'      => 'ltr',
    'peers'    => ['en' => '/en'],
    'menu'     => ['order' => 1, 'title' => 'Inicio'],
    'keywords' => ['wordless', 'cms', 'php', 'español', 'simple'],
]; ?>

<h1>Bienvenido a Wordless</h1>

<p>Un <strong>CMS de archivos planos</strong> en PHP puro, sin dependencias.</p>

<h2>Características</h2>
<ul>
    <?php foreach ([
        'Enrutamiento por archivos — sin configuración de rutas',
        'Contenido en PHP puro — archivos que declaran <code>$meta</code> y HTML',
        'Plantillas PHP nativas — sin motor de plantillas',
        'Localización estructural — <code>en/</code> y <code>es/</code> como árboles de contenido',
        'Caché basado en archivos con TTL configurable',
    ] as $feature): ?>
        <li><?= $feature ?></li>
    <?php endforeach; ?>
</ul>

<blockquote>
    <p>Sin base de datos. Sin Composer. Añade tu magia.</p>
</blockquote>

<p><a href="<?= route('acerca', 'es') ?>">Más sobre el proyecto →</a></p>
