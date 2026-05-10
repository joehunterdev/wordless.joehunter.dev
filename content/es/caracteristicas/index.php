<?php $meta = [
    'title'       => 'Arquitectura y Características',
    'description' => 'Explora la arquitectura de Wordless CMS: enrutamiento, repositorio de contenido, plantillas y más.',
    'peers'       => ['en' => '/features'],
    'menu'        => ['order' => 3, 'title' => 'Características'],
    'keywords'    => ['arquitectura', 'características', 'diseño', 'patrones', 'componentes'],
]; ?>

<h1>Arquitectura y Características</h1>

<p>
    Wordless está construido sobre principios arquitectónicos que priorizan la simplicidad, la claridad y el rendimiento.
    Cada característica representa un patrón de diseño clave que hace el sistema intuitivo y mantenible.
</p>

<h2>Componentes Principales</h2>

<ul>
    <li><a href="<?= route('caracteristicas/nucleo-aplicacion', 'es') ?>">Núcleo de Aplicación</a> — El ciclo de vida de la solicitud y el arranque del sistema</li>
    <li><a href="<?= route('caracteristicas/enrutamiento-archivos', 'es') ?>">Enrutamiento por Archivos</a> — Resolución de URLs mediante convenciones del sistema de archivos</li>
    <li><a href="<?= route('caracteristicas/repositorio-contenido', 'es') ?>">Repositorio de Contenido</a> — Carga y consulta estructurada de contenido</li>
    <li><a href="<?= route('caracteristicas/sistema-plantillas', 'es') ?>">Sistema de Plantillas</a> — Plantillas PHP puras con herencia</li>
    <li><a href="<?= route('caracteristicas/ciclo-solicitudes', 'es') ?>">Ciclo de Vida de Solicitudes</a> — Cómo fluyen las solicitudes por el sistema</li>
    <li><a href="<?= route('caracteristicas/internacionalizacion', 'es') ?>">Internacionalización</a> — Soporte multilingüe via estructura de directorios</li>
    <li><a href="<?= route('caracteristicas/arquitectura-archivos', 'es') ?>">Arquitectura del Sistema de Archivos</a> — Mejores prácticas para organizar el contenido</li>
</ul>

<h2>Filosofía de Diseño</h2>

<p>
    Wordless rechaza la complejidad innecesaria en favor de un diseño transparente y basado en convenciones.
    Cada decisión arquitectónica prioriza la claridad y la mantenibilidad del código.
</p>
