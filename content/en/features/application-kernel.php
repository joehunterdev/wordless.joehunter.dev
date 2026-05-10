<?php $meta = [
    'title'       => 'Application Kernel',
    'description' => 'Understanding the Wordless application kernel: request handling, bootstrapping, and the core request lifecycle.',
    'menu'        => ['parent' => '/en/features', 'order' => 1],
    'keywords'    => ['kernel', 'application', 'bootstrap', 'request', 'lifecycle'],
]; ?>

<h1>Application Kernel</h1>

<p>
    The Application Kernel is the central nervous system of Wordless. It orchestrates the entire request lifecycle
    and coordinates all system components from bootstrap to response.
</p>

<h2>What Is the Application Kernel?</h2>

<p>
    The kernel is a lightweight class that:
</p>

<ul>
    <li>Initializes all services and dependencies</li>
    <li>Routes incoming requests to handlers</li>
    <li>Manages middleware execution</li>
    <li>Coordinates error handling</li>
    <li>Sends responses back to the client</li>
</ul>

<h2>How It Works</h2>

<p>Every request follows this path through the kernel:</p>

<pre><code>Request
  ↓
Application::handle()
  ↓
Middleware Stack
  ↓
Router::resolve()
  ↓
Handler (ContentController, SitemapController, etc)
  ↓
Response
  ↓
send()
</code></pre>

<h2>Bootstrap Process</h2>

<p>The kernel bootstraps in <code>bootstrap/app.php</code>:</p>

<pre><code>&lt;?php
$container = new Container();

// Register services
$container-&gt;singleton(Renderer::class, fn() =&gt; new Renderer($config['template_dir']));
$container-&gt;singleton(ContentRepositoryInterface::class, fn() =&gt;
    new FileContentRepository($config['content_dir'])
);

// Create kernel
$app = new Application($container);
$app-&gt;handle($request);
</code></pre>

<h2>Key Responsibilities</h2>

<h3>Service Coordination</h3>

<p>
    All services (Router, Repository, Renderer) are registered with the container and injected into handlers.
    This ensures loose coupling and testability.
</p>

<h3>Middleware Support</h3>

<p>
    The kernel executes a configurable stack of middleware before passing the request to the router.
    This enables features like error handling and response caching.
</p>

<h3>Error Handling</h3>

<p>
    Exceptions are caught and normalized into structured error responses.
    In debug mode, full stack traces are displayed; in production, user-friendly error pages are shown.
</p>

<h2>Why This Pattern?</h2>

<p>
    A centralized kernel provides:
</p>

<ul>
    <li><strong>Predictability:</strong> The request path is always the same</li>
    <li><strong>Extensibility:</strong> Middleware and hooks can intercept requests</li>
    <li><strong>Testability:</strong> The kernel can be tested in isolation</li>
    <li><strong>Control:</strong> No hidden request routing or magic behavior</li>
</ul>

<p><a href="<?= route('features', 'en') ?>">← Back to Features</a></p>
