<?php

ob_start();
?>
<h1>500 &mdash; Internal Server Error</h1>
<p>Something went wrong. Please try again later.</p>
<p><a href="/">Back to home</a></p>
<?php
$slot      = ob_get_clean();
$pageTitle = '500 Error';
require __DIR__ . '/layouts/base.php';
