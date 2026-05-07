<?php $meta = [
    'title' => 'Acerca de',
    'date'  => '2026-05-05',
    'menu'  => ['order' => 2, 'title' => 'Acerca de'],
]; ?>

<h1>Acerca de Wordless</h1>

<p>Wordless es un CMS mínimo de archivos planos, sin dependencias, construido con PHP moderno.</p>

<h2>Filosofía</h2>
<ul>
    <?php foreach ([
        'Sin base de datos — el contenido vive en archivos PHP',
        'Sin Composer — cero dependencias de terceros',
        'Sin magia — código limpio, legible y testeable',
    ] as $point): ?>
        <li><?= htmlspecialchars($point) ?></li>
    <?php endforeach; ?>
</ul>

<h2>Arquitectura</h2>
<p>Separación estricta de responsabilidades en módulos enfocados:</p>
<ul>
    <li><code>app/Core</code> — Contenedor y núcleo de aplicación</li>
    <li><code>app/Content</code> — Repositorio y cargador de archivos PHP</li>
    <li><code>app/Routing</code> — Resolución de URLs por archivos</li>
    <li><code>app/Http</code> — Request, Response, Controllers, Middleware</li>
    <li><code>app/Templating</code> — Renderer PHP nativo con layouts</li>
    <li><code>app/Cache</code> — Caché de archivos planos con TTL</li>
    <li><code>app/Events</code> — Dispatcher de eventos ligero</li>
    <li><code>app/Plugins</code> — Sistema de registro de plugins</li>
</ul>

<p><a href="/es">← Volver al inicio</a></p>