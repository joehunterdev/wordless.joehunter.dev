<?php

declare(strict_types=1);

namespace Wordless\Http\Controllers;

use Wordless\Core\Container;
use Wordless\Content\ContentRepositoryInterface;
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
        $repo    = $this->container->get(ContentRepositoryInterface::class);
        $content = $repo->find($this->path);

        if ($content === null) {
            /** @var Renderer $renderer */
            $renderer = $this->container->get(Renderer::class);
            return Response::notFound(
                $renderer->render('404', ['path' => $this->path])
            );
        }

        /** @var Renderer $renderer */
        $renderer = $this->container->get(Renderer::class);
        $currentPath = $_SERVER['REQUEST_URI'] ?? '/';

        return Response::html(
            $renderer->render('page', [
                'content' => $content,
                'currentPath' => $currentPath,
            ])
        );
    }
}
