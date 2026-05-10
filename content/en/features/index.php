<?php $meta = [
    'title'       => 'Architecture & Features',
    'description' => 'Explore Wordless CMS architecture: file-based routing, content repository, templating, and more.',
    'menu'        => ['order' => 3, 'title' => 'Features'],
    'keywords'    => ['architecture', 'features', 'design', 'patterns', 'components'],
]; ?>

<h1>Architecture & Features</h1>

<p>
    Wordless is built on core architectural principles that prioritize simplicity, clarity, and performance.
    Each feature represents a key design pattern that makes the system intuitive and maintainable.
</p>

<h2>Core Components</h2>

<ul>
    <li><a href="<?= route('features/application-kernel', 'en') ?>">Application Kernel</a> — The request lifecycle and core bootstrapping</li>
    <li><a href="<?= route('features/file-based-routing', 'en') ?>">File-Based Routing</a> — URL resolution through filesystem conventions</li>
    <li><a href="<?= route('features/content-repository', 'en') ?>">Content Repository</a> — Structured content loading and querying</li>
    <li><a href="<?= route('features/template-system', 'en') ?>">Template System</a> — Pure PHP templating with inheritance</li>
    <li><a href="<?= route('features/request-lifecycle', 'en') ?>">Request Lifecycle</a> — How requests flow through the system</li>
    <li><a href="<?= route('features/internationalization', 'en') ?>">Internationalization</a> — Multi-language support via directory structure</li>
    <li><a href="<?= route('features/filesystem-architecture', 'en') ?>">Filesystem Architecture</a> — Content organization best practices</li>
</ul>

<h2>Design Philosophy</h2>

<p>
    Wordless rejects unnecessary complexity in favor of transparent, convention-based design.
    Every architectural decision prioritizes developer clarity and maintainability.
</p>
