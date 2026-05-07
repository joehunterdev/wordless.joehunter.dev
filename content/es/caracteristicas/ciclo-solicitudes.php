<?php $meta = [
    'title'       => 'Ciclo de Vida de Solicitudes',
    'description' => 'Comprendiendo el ciclo de vida completo de solicitudes en Wordless: desde la petición HTTP hasta la respuesta HTML.',
    'menu'        => ['parent' => '/es/caracteristicas', 'order' => 5],
    'keywords'    => ['solicitud', 'ciclo', 'middleware', 'flujo', 'respuesta'],
]; ?>

<h1>Ciclo de Vida de Solicitudes</h1>

<p>
    Cada solicitud a un sitio Wordless sigue un flujo predecible y transparente.
    Entender este ciclo te ayuda a extender el sistema y depurar problemas.
</p>

<h2>El Flujo Completo</h2>

<pre><code>Solicitud del Navegador
    ↓
/public/index.php (punto de entrada)
    ↓
bootstrap/app.php (inicializa el contenedor y servicios)
    ↓
Application::handle($request)
    ↓
ErrorMiddleware (captura excepciones)
    ↓
CacheMiddleware (comprueba respuestas en caché)
    ↓
Router::resolve($path)
    ↓
¿Rutas Explícitas? (sitemap.xml, rutas personalizadas)
    ↓ No
Rutas por Archivo (ContentController)
    ↓
ContentRepository::find($path)
    ↓
¿Existe el archivo?
    ↓ Sí
PhpFileParser::parseFile() (extrae metadatos, renderiza cuerpo)
    ↓
ContentController::handle() (fusiona con layout)
    ↓
Renderer::render('page', $data)
    ↓
Respuesta enviada al navegador
</code></pre>

<h2>Desglose Paso a Paso</h2>

<h3>1. Punto de Entrada</h3>
<p>
    <code>/public/index.php</code> es el único archivo accesible directamente via HTTP.
    Arranca la aplicación y maneja la solicitud.
</p>

<h3>2. Arranque</h3>
<p><code>bootstrap/app.php</code> inicializa todos los servicios:</p>
<ul>
    <li>Carga la configuración</li>
    <li>Registra servicios en el contenedor</li>
    <li>Arranca los plugins</li>
    <li>Registra rutas con nombre</li>
</ul>

<h3>3. Middleware</h3>
<p>
    El middleware procesa la solicitud antes y después de que llegue al manejador.
    Wordless incluye <mark>ErrorMiddleware</mark> y <mark>CacheMiddleware</mark> por defecto.
</p>

<h3>4. Enrutamiento</h3>
<p>
    El router resuelve la ruta URL a un manejador. Si no se encuentra ninguna ruta explícita,
    el <code>ContentController</code> intenta resolver la ruta mediante el sistema de archivos.
</p>

<h3>5. Respuesta</h3>
<p>
    El manejador devuelve un objeto <code>Response</code> que el núcleo envía al cliente.
</p>

<hr>

<p><a href="/es/caracteristicas">← Volver a Características</a></p>
