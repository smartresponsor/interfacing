<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Crud\Contribution;

use App\Interfacing\Contract\View\CrudResourceLinkSet;
use App\Interfacing\Contract\View\CrudResourceLinkSetInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class AbstractCrudResourceContribution
{
    public function __construct(private readonly UrlGeneratorInterface $url)
    {
    }

    /**
     * @param array<string, string> $routeParameters
     */
    protected function resource(
        string $id,
        string $component,
        string $label,
        string $resourcePath,
        string $indexRoute,
        string $indexFallback,
        string $newRoute,
        string $newFallback,
        string $showPattern,
        string $editPattern,
        string $deletePattern,
        ?string $note = null,
        array $routeParameters = [],
    ): CrudResourceLinkSetInterface {
        return new CrudResourceLinkSet(
            id: $id,
            component: $component,
            label: $label,
            resourcePath: $resourcePath,
            indexUrl: $this->safeUrl($indexRoute, $indexFallback, $routeParameters),
            newUrl: $this->safeUrl($newRoute, $newFallback, $routeParameters),
            showPattern: $showPattern,
            editPattern: $editPattern,
            deletePattern: $deletePattern,
            note: $note,
        );
    }

    /**
     * @param array<string, string> $parameters
     */
    protected function safeUrl(string $route, string $fallback, array $parameters = []): string
    {
        try {
            return $this->url->generate($route, $parameters);
        } catch (\Throwable) {
            return $fallback;
        }
    }
}
