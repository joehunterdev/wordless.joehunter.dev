<?php $meta = [
    'title'       => 'Núcleo de Aplicación',
    'description' => 'Comprendiendo el núcleo de la aplicación Wordless: manejo de solicitudes, arranque y el ciclo de vida central.',
    'menu'        => ['parent' => '/es/caracteristicas', 'order' => 1],
    'keywords'    => ['núcleo', 'aplicación', 'bootstrap', 'solicitud', 'ciclo'],
]; ?>

<h1>Núcleo de Aplicación</h1>

<p>
    El Núcleo de Aplicación es el sistema nervioso central de Wordless. Orquesta todo el ciclo de vida
    de las solicitudes y coordina todos los componentes del sistema desde el arranque hasta la respuesta.
</p>

<h2>¿Qué Es el Núcleo de Aplicación?</h2>

<p>El núcleo es una clase ligera que:</p>

<ul>
    <li>Inicializa todos los servicios y dependencias</li>
    <li>Enruta las solicitudes entrantes a los manejadores</li>
    <li>Gestiona la ejecución del middleware</li>
    <li>Coordina el manejo de errores</li>
    <li>Envía respuestas de vuelta al cliente</li>
</ul>

<h2>Cómo Funciona</h2>

<p>Cada solicitud sigue este camino por el núcleo:</p>

<pre><code>Solicitud
  ↓
Application::handle()
  ↓
Pila de Middleware
  ↓
Router::resolve()
  ↓
Manejador (ContentController, SitemapController, etc.)
  ↓
Respuesta
  ↓
send()
</code></pre>

<h2>Proceso de Arranque</h2>

<p>El núcleo arranca en <code>bootstrap/app.php</code>:</p>

<pre><code>&lt;?php
$container = new Container();

// Registrar servicios
$container-&gt;singleton(Renderer::class, fn() =&gt; new Renderer($config['template_dir']));
$container-&gt;singleton(ContentRepositoryInterface::class, fn() =&gt;
    new FileContentRepository($config['content_dir'])
);
</code></pre>

<h2>Inyección de Dependencias</h2>

<p>
    El núcleo utiliza un contenedor de servicios simple para gestionar las dependencias.
    Cada servicio se registra una vez y se resuelve automáticamente.
</p>

<dl>
    <dt><code>Container::singleton()</code></dt>
    <dd>Registra un servicio que se instancia una sola vez y se reutiliza</dd>

    <dt><code>Container::get()</code></dt>
    <dd>Resuelve un servicio por nombre de clase o interfaz</dd>
</dl>

<hr>

<p><a href="<?= route('caracteristicas', 'es') ?>">← Volver a Características</a></p>
