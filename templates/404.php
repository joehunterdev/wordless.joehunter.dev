<?php
/** @var string $path */

ob_start();
?>
<h1>404 &mdash; Page Not Found</h1>
<p>No content found for <code><?= htmlspecialchars($path) ?></code>.</p>
<p><a href="/">Back to home</a></p>
<?php
$slot      = ob_get_clean();
$pageTitle = '404 Not Found';
require __DIR__ . '/layouts/base.php';
