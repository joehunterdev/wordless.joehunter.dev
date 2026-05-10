<?php

declare(strict_types=1);

namespace Wordless\Content;

final class PeerMap
{
    public function __construct(
        private readonly string $contentDir,
        private readonly array  $locales,
        private readonly string $defaultLocale
    ) {}

    /**
     * Return resolved peers for $canonicalPath.
     * Peers are computed at runtime by matching the same relative slug across locale dirs.
     * $fileOverrides (from $meta['peers']) win over computed entries.
     * Null entries are stripped — they mean "no known peer".
     */
    public function peersFor(string $canonicalPath, array $fileOverrides = []): array
    {
        $computed = $this->computePeers($canonicalPath);
        $merged   = array_merge($computed, $fileOverrides);
        return array_filter($merged, static fn($v) => $v !== null);
    }

    private function computePeers(string $canonicalPath): array
    {
        [$locale, $relativeSlug] = $this->parseCanonicalPath($canonicalPath);

        $peers = [];
        foreach ($this->locales as $otherLocale) {
            if ($otherLocale === $locale) {
                continue;
            }
            $peers[$otherLocale] = $this->findPeerPath($relativeSlug, $otherLocale);
        }

        return $peers;
    }

    /**
     * Resolve the canonical path back to [locale, relativeSlug].
     * Default locale paths have no locale prefix: /about → ['en', 'about'].
     * Non-default locale paths carry the prefix: /es/acerca → ['es', 'acerca'].
     */
    private function parseCanonicalPath(string $canonicalPath): array
    {
        $path = ltrim($canonicalPath, '/');

        foreach ($this->locales as $locale) {
            if ($locale === $this->defaultLocale) {
                continue;
            }
            if ($path === $locale) {
                return [$locale, ''];
            }
            if (str_starts_with($path, $locale . '/')) {
                return [$locale, substr($path, strlen($locale) + 1)];
            }
        }

        return [$this->defaultLocale, $path];
    }

    /**
     * Find the canonical URL of $relativeSlug in $locale's content directory.
     * Returns null if no matching file exists.
     */
    private function findPeerPath(string $relativeSlug, string $locale): ?string
    {
        if ($relativeSlug === '') {
            return $locale === $this->defaultLocale ? '/' : '/' . $locale;
        }

        $base = $this->contentDir . DIRECTORY_SEPARATOR . $locale . DIRECTORY_SEPARATOR;
        $rel  = str_replace('/', DIRECTORY_SEPARATOR, $relativeSlug);

        foreach ([$base . $rel . '.php', $base . $rel . DIRECTORY_SEPARATOR . 'index.php'] as $file) {
            if (file_exists($file)) {
                return $locale === $this->defaultLocale
                    ? '/' . $relativeSlug
                    : '/' . $locale . '/' . $relativeSlug;
            }
        }

        return null;
    }
}
