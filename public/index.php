<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

/** @var \Wordless\Core\Application $app */
$app = require __DIR__ . '/../bootstrap/app.php';

$request  = \Wordless\Http\Request::fromGlobals();
$response = $app->handle($request);
$response->send();
