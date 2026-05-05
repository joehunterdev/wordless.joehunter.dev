<?php $meta = [
    'title'       => 'Request Lifecycle',
    'description' => 'Understanding the complete request lifecycle in Wordless: from HTTP request to HTML response.',
    'date'        => '2026-05-05',
]; ?>

<h1>Request Lifecycle</h1>

<p>
    Every request to a Wordless site follows a predictable, transparent flow.
    Understanding this lifecycle helps you extend the system and debug issues.
</p>

<h2>The Complete Flow</h2>

<pre><code>Browser Request
    ↓
/public/index.php (entry point)
    ↓
bootstrap/app.php (initialize container and services)
    ↓
Application::handle($request)
    ↓
ErrorMiddleware (catches exceptions)
    ↓
CacheMiddleware (checks for cached responses)
    ↓
Router::resolve($path)
    ↓
Explicit Routes? (sitemap.xml, custom routes)
    ↓ No
File-Based Routes (ContentController)
    ↓
ContentRepository::find($path)
    ↓
File exists?
    ↓ Yes
PhpFileParser::parseFile() (extract metadata, render body)
    ↓
ContentController::handle() (merge with layout)
    ↓
Renderer::render('page', $data)
    ↓
Response sent to browser
</code></pre>

<h2>Step-by-Step Breakdown</h2>

<h3>1. Entry Point</h3>

<p>
    <code>/public/index.php</code> is the only file directly accessible via HTTP.
    It bootstraps the application and handles the request.
</p>

<pre><code>&lt;?php
$app = require __DIR__ . '/../bootstrap/app.php';
$request = Request::fromGlobals();
$response = $app-&gt;handle($request);
$response-&gt;send();
</code></pre>

<h3>2. Bootstrap</h3>

<p>
    <code>bootstrap/app.php</code> initializes all services:
</p>

<ul>
    <li>Load configuration</li>
    <li>Register services in the container</li>
    <li>Boot plugins</li>
    <li>Register named routes</li>
</ul>

<h3>3. Request Parsing</h3>

<p>
    The <code>Request</code> object extracts:
</p>

<ul>
    <li>HTTP method (GET, POST, etc.)</li>
    <li>Path (/about, /blog/hello-world)</li>
    <li>Query parameters</li>
    <li>Headers</li>
</ul>

<h3>4. Middleware Stack</h3>

<p>
    Middleware wraps the main request handling:
</p>

<pre><code>ErrorMiddleware
  └─ CacheMiddleware
      └─ Router
</code></pre>

<p>
    Each middleware can inspect, modify, or intercept requests and responses.
</p>

<h3>5. Routing</h3>

<p>
    The router checks for explicit routes first (e.g., <code>/sitemap.xml</code>),
    then falls back to file-based routing for regular pages.
</p>

<h3>6. Content Loading</h3>

<p>
    The repository finds the matching file, extracts metadata, and renders the content body.
</p>

<h3>7. Rendering</h3>

<p>
    If the content template declares a layout, the body is wrapped in that layout.
</p>

<h3>8. Response</h3>

<p>
    The final HTML is sent back to the browser with appropriate headers and status code.
</p>

<h2>Error Handling</h2>

<p>
    If any step fails:
</p>

<ul>
    <li>404: Content file not found</li>
    <li>500: Exception thrown during rendering</li>
    <li>The ErrorMiddleware catches the exception</li>
    <li>An error template is rendered with the appropriate status code</li>
</ul>

<h2>Caching</h2>

<p>
    The CacheMiddleware checks if a response is cached and returns it directly,
    bypassing the expensive content loading and rendering steps.
</p>

<h2>Key Principles</h2>

<ul>
    <li><strong>Transparency:</strong> No hidden routing or magic behavior</li>
    <li><strong>Predictability:</strong> The flow is always the same</li>
    <li><strong>Extensibility:</strong> Middleware and hooks allow customization</li>
    <li><strong>Performance:</strong> Middleware like caching can optimize before expensive operations</li>
</ul>

<p><a href="/en/features">← Back to Features</a></p>
