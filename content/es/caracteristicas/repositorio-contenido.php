<?php $meta = [
    'title'       => 'Repositorio de Contenido',
    'description' => 'El patrón Repositorio de Contenido en Wordless: carga estructurada, consultas y herencia de metadatos.',
    'menu'        => ['order' => 3],
    'keywords'    => ['repositorio', 'contenido', 'cargador', 'metadatos', 'patrón'],
]; ?>

<h1>Repositorio de Contenido</h1>

<p>
    El Repositorio de Contenido abstrae los detalles de carga y consulta de archivos de contenido.
    Proporciona una interfaz limpia para encontrar páginas individuales y listar todo el contenido de una sección.
</p>

<blockquote>
    <p>El repositorio oculta la complejidad. Tu código solo pide contenido — no le importa dónde vive.</p>
</blockquote>

<h2>¿Qué Es un Repositorio?</h2>

<p>
    Un <dfn>repositorio</dfn> es un patrón de diseño que actúa como intermediario entre tu código y el almacenamiento de datos.
    En Wordless, el repositorio oculta la complejidad de:
</p>

<ul>
    <li>Localizar archivos en el sistema de archivos</li>
    <li>Parsear archivos de contenido PHP</li>
    <li>Extraer metadatos</li>
    <li>Construir objetos <code>Content</code> estructurados</li>
</ul>

<h2>Métodos Principales</h2>

<h3>find()</h3>
<p>Recupera una página individual por su ruta:</p>
<pre><code>$repo = $container-&gt;get(ContentRepositoryInterface::class);
$page = $repo-&gt;find('/blog/hola-mundo');

if ($page) {
    echo $page-&gt;title;
    echo $page-&gt;body;
}
</code></pre>

<h3>all()</h3>
<p>Lista todo el contenido de una sección:</p>
<pre><code>// Todo el contenido
$pages = $repo-&gt;all();

// Solo posts del blog
$posts = $repo-&gt;all('blog');
</code></pre>

<h2>Objetos de Contenido</h2>

<dl>
    <dt><code>$content->title</code></dt>
    <dd>El título de la página extraído de los metadatos</dd>

    <dt><code>$content->body</code></dt>
    <dd>HTML renderizado del cuerpo del archivo de contenido</dd>

    <dt><code>$content->slug</code></dt>
    <dd>Slug de URL, p.ej. <samp>blog/hola-mundo</samp></dd>

    <dt><code>$content->get($clave, $defecto)</code></dt>
    <dd>Acceso seguro a cualquier valor de metadato</dd>
</dl>

<h2>Herencia de Metadatos</h2>

<p>
    Las páginas hijas heredan automáticamente los metadatos de su <code>index.php</code> padre.
    Los metadatos más internos ganan en caso de conflicto.
</p>

<table>
    <thead>
        <tr><th>Archivo</th><th>Metadato</th><th>Resultado</th></tr>
    </thead>
    <tbody>
        <tr><td><code>es/index.php</code></td><td><code>language: es</code></td><td>Heredado por los hijos</td></tr>
        <tr><td><code>es/algo.php</code></td><td><code>title: Algo</code></td><td>Fusionado con el padre</td></tr>
    </tbody>
</table>

<hr>

<p><a href="<?= route('caracteristicas', 'es') ?>">← Volver a Características</a></p>
