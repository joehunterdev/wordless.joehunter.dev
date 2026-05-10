<?php $meta = [
    'title'       => 'Blog',
    'description' => 'Artículos y actualizaciones del proyecto Wordless — un CMS de archivos planos en PHP puro.',
    'menu'        => ['order' => 4, 'title' => 'Blog'],
    'keywords'    => ['wordless', 'blog', 'php', 'cms', 'archivos planos'],
]; ?>

<h1>Blog</h1>

<p>
    Las entradas del blog viven como archivos PHP bajo <code>content/es/blog/</code>.
    Cada archivo se convierte en una URL automáticamente — sin base de datos, sin interfaz de administración.
</p>

<p>Sin entradas aún. Vuelve pronto.</p>

<p><a href="<?= route('acerca', 'es') ?>">&#8592; Acerca de Wordless</a></p>