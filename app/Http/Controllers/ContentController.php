<?php

declare(strict_types=1);

namespace Wordless\Http\Controllers;

use Wordless\Core\Container;
use Wordless\Content\Content;
use Wordless\Content\ContentRepositoryInterface;
use Wordless\Content\PeerMap;
use Wordless\Http\HandlerInterface;
use Wordless\Http\Request;
use Wordless\Http\Response;
use Wordless\Templating\Renderer;

class ContentController implements HandlerInterface
{
    public function __construct(
        private readonly Container $container,
        private readonly string    $path
    ) {}

    public function handle(Request $request): Response
    {
        /** @var ContentRepositoryInterface $repo */
        $repo     = $this->container->get(ContentRepositoryInterface::class);
        /** @var Renderer $renderer */
        $renderer = $this->container->get(Renderer::class);
        /** @var PeerMap $peerMap */
        $peerMap  = $this->container->get(PeerMap::class);

        $currentPath = $this->path === '' ? '/' : '/' . ltrim($this->path, '/');
        $content     = $repo->find($this->path, $renderer, $currentPath);

        if ($content === null) {
            return Response::notFound(
                $renderer->render('404', ['path' => $this->path])
            );
        }

        // Merge generated peer map with any file-level overrides from $meta['peers']
        $resolvedPeers = $peerMap->peersFor($currentPath, $content->meta['peers'] ?? []);
        $content = new Content(
            title: $content->title,
            body:  $content->body,
            slug:  $content->slug,
            meta:  array_merge($content->meta, ['peers' => $resolvedPeers]),
        );

        return Response::html(
            $renderer->render('page', [
                'content'     => $content,
                'currentPath' => $currentPath,
            ])
        );
    }
}
