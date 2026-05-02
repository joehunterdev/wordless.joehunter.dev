<?php

declare(strict_types=1);

namespace Wordless\Http;

interface HandlerInterface
{
    public function handle(Request $request): Response;
}
