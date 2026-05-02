<?php

declare(strict_types=1);

namespace Wordless\Events;

use Wordless\Content\Content;

class ContentLoadedEvent
{
    public function __construct(
        public readonly Content $content
    ) {}
}
