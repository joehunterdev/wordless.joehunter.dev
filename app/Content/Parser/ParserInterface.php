<?php

declare(strict_types=1);

namespace Wordless\Content\Parser;

use Wordless\Content\Content;

interface ParserInterface
{
    public function parseFile(string $filePath, string $slug): Content;
}
