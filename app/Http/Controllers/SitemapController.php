<?php

declare(strict_types=1);

namespace Wordless\Http\Controllers;

use Wordless\Content\ContentRepositoryInterface;
use Wordless\Core\Container;
use Wordless\Http\HandlerInterface;
use Wordless\Http\Request;
use Wordless\Http\Response;

class SitemapController implements HandlerInterface
{
    public function __construct(private readonly Container $container) {}

    public function handle(Request $request): Response
    {
        /** @var ContentRepositoryInterface $repo */
        $repo   = $this->container->get(ContentRepositoryInterface::class);
        $config = $this->container->get('config');

        $baseUrl = rtrim($config['base_url'] ?? $this->inferBaseUrl($request), '/');

        $pages = $repo->all();

        $xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($pages as $page) {
            $loc      = $baseUrl . '/' . ltrim($page->slug, '/');
            $lastmod  = $page->get('date') ?? date('Y-m-d');
            $priority = $page->slug === 'home' ? '1.0' : '0.8';

            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($loc, ENT_XML1) . "</loc>\n";
            $xml .= "    <lastmod>" . htmlspecialchars($lastmod, ENT_XML1) . "</lastmod>\n";
            $xml .= "    <priority>{$priority}</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return new Response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    private function inferBaseUrl(Request $request): string
    {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
        return $scheme . '://' . $host;
    }
}
