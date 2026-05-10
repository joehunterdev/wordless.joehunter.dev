<?php

declare(strict_types=1);

namespace Wordless\Content;

final class PeerMap
{
    public function __construct(private readonly array $map) {}

    public static function load(string $mapFile): self
    {
        $map = file_exists($mapFile) ? (require $mapFile) : [];
        return new self(is_array($map) ? $map : []);
    }

    /**
     * Return resolved peers for $path.
     * $fileOverrides (from $meta['peers']) win over generated entries.
     * Null entries are stripped — they mean "no known peer, fall back to locale root".
     */
    public function peersFor(string $path, array $fileOverrides = []): array
    {
        $base   = $this->map[$path] ?? [];
        $merged = array_merge($base, $fileOverrides);
        return array_filter($merged, static fn($v) => $v !== null);
    }
}
