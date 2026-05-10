<?php $meta = [
    'title'       => 'Sistema de Plantillas',
    'description' => 'Plantillas PHP puras en Wordless: layouts, parciales y mejores prácticas para construir vistas reutilizables.',
    'menu'        => ['order' => 4],
    'keywords'    => ['plantillas', 'vistas', 'layouts', 'parciales', 'php'],
]; ?>

<h1>Sistema de Plantillas</h1>

<p>
    Wordless usa PHP puro para las plantillas, sin ningún motor de plantillas externo.
    Esto significa curva de aprendizaje cero y acceso completo al poder de PHP cuando se necesite.
</p>

<h2>¿Por Qué PHP Puro?</h2>

<ul>
    <li><strong>Sin overhead de abstracción:</strong> Escribe HTML y PHP directamente</li>
    <li><strong>Funcionalidades completas del lenguaje:</strong> Usa cualquier función de PHP sin restricciones</li>
    <li><strong>Rendimiento rápido:</strong> Sin paso de compilación ni parseo de plantillas</li>
    <li><strong>Sintaxis familiar:</strong> Los desarrolladores ya conocen PHP</li>
    <li><strong>Sin dependencias:</strong> No hay librerías adicionales que instalar</li>
</ul>

<h2>Estructura de Plantillas</h2>

<h3>Layouts</h3>
<p>Los layouts envuelven las páginas de contenido con cabeceras, pies de página y navegación:</p>
<pre><code>&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;?= $renderer-&gt;partial('head', ['pageTitle' =&gt; $pageTitle]) ?&gt;
&lt;body&gt;
    &lt;?= $renderer-&gt;partial('nav') ?&gt;
    &lt;main&gt;
        &lt;?= $slot ?&gt;
    &lt;/main&gt;
&lt;/body&gt;
&lt;/html&gt;
</code></pre>

<h3>Parciales</h3>
<p>Los componentes reutilizables se almacenan como parciales en <code>templates/partials/</code>:</p>
<pre><code>templates/partials/
  head.php        → &lt;head&gt; con meta tags y CSS
  nav.php         → Menú de navegación
  lang-switch.php → Selector de idioma
</code></pre>

<h3>Páginas de Contenido</h3>
<pre><code>&lt;?php
$layout    = 'base';
$pageTitle = $content-&gt;title;
?&gt;

&lt;article&gt;
    &lt;?= $content-&gt;body ?&gt;
&lt;/article&gt;
</code></pre>

<h2>Escape de Salida</h2>

<p>
    Wordless proporciona una función auxiliar <code>e()</code> para escapar HTML de forma segura.
    Úsala siempre que renderices contenido dinámico no confiable:
</p>

<pre><code>&lt;?= e($content-&gt;title) ?&gt;
&lt;?= e($userInput) ?&gt;
</code></pre>

<p>
    El cuerpo del contenido (<code>$content->body</code>) ya está renderizado y es HTML de confianza,
    por lo que no necesita escaparse.
</p>

<hr>

<p><a href="<?= route('caracteristicas', 'es') ?>">← Volver a Características</a></p>
