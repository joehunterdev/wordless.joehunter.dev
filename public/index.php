<?php

declare(strict_types=1);

/** @var \Wordless\Core\Application $app */
$app = require __DIR__ . '/../bootstrap/app.php';

$request  = \Wordless\Http\Request::fromGlobals();
$response = $app->handle($request);
$response->send();
