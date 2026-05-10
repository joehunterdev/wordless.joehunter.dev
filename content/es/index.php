<?php $meta = [
    'title'    => 'Inicio',
    'lang'     => 'es',
    'locale'   => 'es-ES',
    'dir'      => 'ltr',
    'peers'    => ['en' => '/en'],
    'menu'     => ['order' => 1, 'title' => 'Inicio'],
    'keywords' => ['wordless', 'cms', 'php', 'español', 'simple'],
]; ?>

<?= $renderer->partial('nav', ['currentPath' => $currentPath ?? '', 'pageMeta' => $meta]) ?>

<h1>Bienvenido a Wordless</h1>

<p>Un <strong>CMS de archivos planos</strong> en PHP puro, sin dependencias.</p>

<h2>Características</h2>
<ul>
    <?php foreach ([
        'Enrutamiento por archivos',
        'Contenido en PHP o Markdown',
        'Plantillas PHP nativas',
        'Caché basado en archivos',
        'Sistema de plugins y eventos',
    ] as $feature): ?>
        <li><?= e($feature) ?></li>
    <?php endforeach; ?>
</ul>

<blockquote>
    <p>Sin base de datos. Sin Composer. Sin magia.</p>
</blockquote>

<p><a href="<?= route('acerca', 'es') ?>">Más sobre el proyecto →</a></p>
