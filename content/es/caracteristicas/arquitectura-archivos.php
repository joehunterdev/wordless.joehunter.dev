<?php $meta = [
    'title'       => 'Arquitectura del Sistema de Archivos',
    'description' => 'Mejores prácticas para organizar el contenido en Wordless: estructura de carpetas, convenciones de nombres y patrones escalables.',
    'date'        => '2026-05-05',
]; ?>

<h1>Arquitectura del Sistema de Archivos</h1>

<p>
    La organización de tu contenido define la estructura de tu sitio. Esta guía describe las mejores
    prácticas para construir sitios Wordless escalables y mantenibles.
</p>

<h2>Estructura del Proyecto</h2>

<pre><code>wordless-site/
  ├── public/              (raíz web)
  │   ├── index.php        (punto de entrada)
  │   ├── .htaccess        (reglas de enrutamiento)
  │   └── assets/
  │       ├── css/
  │       ├── js/
  │       └── img/
  ├── content/             (todo el contenido del sitio)
  │   ├── index.php        (página de inicio)
  │   ├── about.php
  │   ├── en/              (sección en inglés)
  │   │   ├── index.php
  │   │   └── features/
  │   ├── es/              (sección en español)
  │   │   ├── index.php
  │   │   └── features/
  │   └── docs/            (documentación)
  ├── templates/           (archivos de vista)
  │   ├── layouts/
  │   │   └── base.php
  │   ├── partials/
  │   └── page.php
  ├── app/                 (código de aplicación)
  ├── bootstrap/           (inicialización)
  └── storage/             (caché, logs)
</code></pre>

<h2>Convenciones de Nombres</h2>

<h3>Nombres de Archivos</h3>
<p>Usa nombres en minúsculas con guiones para todos los archivos:</p>

<table>
    <thead>
        <tr><th>Correcto</th><th>Incorrecto</th></tr>
    </thead>
    <tbody>
        <tr><td><code>primeros-pasos.php</code></td><td><code>PrimerosPassos.php</code></td></tr>
        <tr><td><code>enrutamiento-archivos.php</code></td><td><code>enrutamiento_archivos.php</code></td></tr>
        <tr><td><code>hola-mundo.php</code></td><td><code>holamundo.php</code></td></tr>
    </tbody>
</table>

<h2>Organización de Contenido</h2>

<dl>
    <dt>Páginas de sección (<code>index.php</code>)</dt>
    <dd>Cada carpeta puede tener un <code>index.php</code> que actúa como página de listado o introducción de la sección</dd>

    <dt>Páginas de contenido</dt>
    <dd>Archivos individuales que representan una única página o artículo</dd>

    <dt>Secciones de idioma</dt>
    <dd>Carpetas de nivel superior por idioma (<code>en/</code>, <code>es/</code>) con sus propios metadatos heredables</dd>
</dl>

<h2>Mejores Prácticas</h2>

<ul>
    <li>Mantén el contenido plano cuando sea posible — menos anidamiento es más fácil de gestionar</li>
    <li>Usa <code>index.php</code> para las páginas de listado de sección</li>
    <li>Los metadatos de idioma en la carpeta raíz de idioma se heredan automáticamente</li>
    <li>Las rutas de activos (<code>/assets/css/</code>, <code>/assets/js/</code>) viven en <code>public/</code></li>
</ul>

<hr>

<p><a href="/es/caracteristicas">← Volver a Características</a></p>
