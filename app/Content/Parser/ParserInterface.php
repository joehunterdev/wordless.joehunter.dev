<?php

declare(strict_types=1);

namespace Wordless\Content\Parser;

use Wordless\Content\Content;

interface ParserInterface
{
    public function parse(string $raw, string $slug): Content;
}
