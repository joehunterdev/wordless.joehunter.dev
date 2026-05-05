<?php
/** @var string $pageTitle */
$title = $pageTitle !== '' ? e($pageTitle) . ' &mdash; ' : '';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?>Wordless</title>
    <link rel="stylesheet" href="/assets/css/app.css">
    <script type="module" src="/assets/js/app.js"></script>
</head>
