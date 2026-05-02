<?php
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI']    = '/';

require 'e:/www/wordless.joehunter.dev/bootstrap/autoload.php';

$app      = require 'e:/www/wordless.joehunter.dev/bootstrap/app.php';
$request  = \Wordless\Http\Request::fromGlobals();
$response = $app->handle($request);

echo "Status: " . $response->getStatusCode() . PHP_EOL;
echo substr($response->getBody(), 0, 500) . PHP_EOL;
