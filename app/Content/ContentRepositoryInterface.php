<?php

declare(strict_types=1);

namespace Wordless\Content;

interface ContentRepositoryInterface
{
    public function find(string $path): ?Content;

    /** @return Content[] */
    public function all(string $path = ''): array;
}
