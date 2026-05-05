<?php

declare(strict_types=1);

namespace Wordless\Http;

class Request
{
    private readonly string $method;
    private readonly string $path;
    private readonly string $locale;
    private readonly array  $query;
    private readonly array  $headers;

    public function __construct(
        string $method,
        string $path,
        string $locale = '',
        array $query = [],
        array $headers = []
    ) {
        $this->method  = strtoupper($method);
        $this->path    = '/' . trim($path, '/');
        $this->locale  = $locale;
        $this->query   = $query;
        $this->headers = $headers;
    }

    public static function fromGlobals(): self
    {
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';

        return new self(
            method:  $_SERVER['REQUEST_METHOD'] ?? 'GET',
            path:    $path,
            query:   $_GET,
            headers: getallheaders() ?: []
        );
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getQuery(string $key, mixed $default = null): mixed
    {
        return $this->query[$key] ?? $default;
    }

    public function getHeader(string $name): ?string
    {
        return $this->headers[$name] ?? null;
    }
}
