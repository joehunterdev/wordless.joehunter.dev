<?php $meta = [
    'title'       => 'Enrutamiento por Archivos',
    'description' => 'Cómo Wordless mapea URLs directamente al sistema de archivos. Sin configuración, sin definiciones de rutas.',
    'date'        => '2026-05-05',
]; ?>

<h1>Enrutamiento por Archivos</h1>

<p>
    Wordless usa el sistema de archivos como fuente de verdad para el enrutamiento. Cada ruta URL mapea
    directamente a un archivo o carpeta, eliminando la necesidad de archivos de configuración de rutas.
</p>

<h2>Concepto Central</h2>

<p>Existe una relación 1 a 1 entre URLs y archivos:</p>

<table>
    <thead>
        <tr><th>URL</th><th>Archivo</th></tr>
    </thead>
    <tbody>
        <tr><td><code>/</code></td><td><code>content/index.php</code></td></tr>
        <tr><td><code>/about</code></td><td><code>content/about.php</code></td></tr>
        <tr><td><code>/blog/hola-mundo</code></td><td><code>content/blog/hola-mundo.php</code></td></tr>
        <tr><td><code>/features/enrutamiento</code></td><td><code>content/features/enrutamiento.php</code></td></tr>
    </tbody>
</table>

<h2>Cómo Funciona la Resolución</h2>

<p>Cuando llega una solicitud para <code>/blog/hola-mundo</code>, el router:</p>

<ol>
    <li>Comprueba <code>content/blog/hola-mundo.php</code> (coincidencia de archivo)</li>
    <li>Si no existe, comprueba <code>content/blog/hola-mundo/index.php</code> (coincidencia de carpeta)</li>
    <li>Si aún no existe, devuelve un 404</li>
</ol>

<h2>Ventajas</h2>

<h3>Sin Configuración</h3>
<p>
    No necesitas definir rutas en un archivo de configuración. La estructura del sistema de archivos
    <em>es</em> la definición de rutas. Añade un archivo y la URL existe inmediatamente.
</p>

<h3>Transparencia</h3>
<p>
    Cualquier desarrollador puede entender la estructura del sitio simplemente mirando el directorio
    <code>content/</code>. No hay magia oculta.
</p>

<h3>Soporte Multilingüe</h3>
<p>
    El enrutamiento por archivos hace que el soporte multilingüe sea natural:
</p>
<pre><code>content/
  en/
    features/
      file-based-routing.php  →  /en/features/file-based-routing
  es/
    features/
      enrutamiento.php        →  /es/features/enrutamiento
</code></pre>

<hr>

<p><a href="/es/caracteristicas">← Volver a Características</a></p>
