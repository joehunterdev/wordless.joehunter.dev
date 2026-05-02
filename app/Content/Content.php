<?php

declare(strict_types=1);

namespace Wordless\Content;

final class Content
{
    public function __construct(
        public readonly string $title,
        public readonly string $body,
        public readonly string $slug,
        public readonly array  $meta = []
    ) {}

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->meta[$key] ?? $default;
    }
}
