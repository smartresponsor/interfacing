<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Crud;

use App\Interfacing\Contract\Crud\CrudOperationGrammarInterface;
use App\Interfacing\Contract\Crud\CrudResourceDescriptorInterface;
use App\Interfacing\Contract\View\CrudResourceLinkSet;
use App\Interfacing\Contract\View\CrudResourceLinkSetInterface;
use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudOperationGrammarProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceDescriptorContributionInterface;
use App\Interfacing\ServiceInterface\Interfacing\Crud\CrudResourceExplorerProviderInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final readonly class CrudResourceExplorerProvider implements CrudResourceExplorerProviderInterface
{
    /** @param iterable<CrudResourceDescriptorContributionInterface> $contributions */
    public function __construct(
        private iterable $contributions,
        private CrudOperationGrammarProviderInterface $operationGrammarProvider,
        private ?UrlGeneratorInterface $url = null,
    ) {
    }

    public function provide(): array
    {
        static $cache = null;
        if (null !== $cache) {
            return $cache;
        }

        /** @var array<string, CrudResourceLinkSetInterface> $byId */
        $byId = [];

        foreach ($this->contributions as $contribution) {
            if (!$contribution instanceof CrudResourceDescriptorContributionInterface) {
                continue;
            }

            foreach ($contribution->provide() as $resource) {
                $linkSet = $this->normalizeResource($resource);
                if (null === $linkSet) {
                    continue;
                }

                $current = $byId[$linkSet->id()] ?? null;
                if (null === $current || $this->priority($linkSet) > $this->priority($current)) {
                    $byId[$linkSet->id()] = $linkSet;
                }
            }
        }

        $list = array_values($byId);
        usort(
            $list,
            static fn (CrudResourceLinkSetInterface $left, CrudResourceLinkSetInterface $right): int => [
                $left->component(),
                $left->label(),
                $left->id(),
            ] <=> [
                $right->component(),
                $right->label(),
                $right->id(),
            ],
        );

        return $cache = $list;
    }

    private function normalizeResource(object $resource): ?CrudResourceLinkSetInterface
    {
        if ($resource instanceof CrudResourceLinkSetInterface) {
            return $resource;
        }

        if (!$resource instanceof CrudResourceDescriptorInterface) {
            return null;
        }

        $show = $this->operation('show');
        $edit = $this->operation('edit');
        $delete = $this->operation('delete');

        return new CrudResourceLinkSet(
            id: $resource->id(),
            component: $resource->component(),
            label: $resource->label(),
            resourcePath: $resource->resourcePath(),
            indexUrl: $this->safeUrl($resource->indexRoute(), $resource->indexFallback(), $resource->routeParameters()),
            newUrl: $this->safeUrl($resource->newRoute(), $resource->newFallback(), $resource->routeParameters()),
            showPattern: $resource->showPattern(),
            editPattern: $resource->editPattern(),
            deletePattern: $resource->deletePattern(),
            note: $resource->note(),
            status: $resource->status(),
            sampleIdentifier: $resource->sampleIdentifier(),
            showSampleUrl: $this->safeOperationUrl($show, $resource->resourcePath(), $resource->sampleIdentifier(), $this->materialize($resource->showPattern(), $resource->sampleIdentifier()), $resource->routeParameters()),
            editSampleUrl: $this->safeOperationUrl($edit, $resource->resourcePath(), $resource->sampleIdentifier(), $this->materialize($resource->editPattern(), $resource->sampleIdentifier()), $resource->routeParameters()),
            deleteSampleUrl: $this->safeOperationUrl($delete, $resource->resourcePath(), $resource->sampleIdentifier(), $this->materialize($resource->deletePattern(), $resource->sampleIdentifier()), $resource->routeParameters()),
        );
    }


    private function operation(string $operation): ?CrudOperationGrammarInterface
    {
        return $this->operationGrammarProvider->get($operation);
    }

    /**
     * @param array<string, string> $routeParameters
     */
    private function safeOperationUrl(?CrudOperationGrammarInterface $operation, string $resourcePath, string $sampleIdentifier, string $fallback, array $routeParameters = []): string
    {
        if (null === $operation) {
            return $fallback;
        }

        return $this->safeUrl(
            $operation->routeName(),
            $fallback,
            array_merge($routeParameters, $operation->routeParameters($resourcePath, $sampleIdentifier)),
        );
    }

    private function priority(CrudResourceLinkSetInterface $resource): int
    {
        return match ($resource->status()) {
            'connected' => 300,
            'canonical' => 200,
            'planned' => 100,
            default => 0,
        };
    }

    private function materialize(string $pattern, string $sampleIdentifier): string
    {
        return str_replace(['{id}', '{id|slug}'], $sampleIdentifier, $pattern);
    }

    /**
     * @param array<string, string> $routeParameters
     *
     * @return array<string, string>
     */
    private function withSampleIdentifier(array $routeParameters, string $sampleIdentifier): array
    {
        $routeParameters['id'] = $sampleIdentifier;

        return $routeParameters;
    }

    /**
     * @param array<string, string> $parameters
     */
    private function safeUrl(string $route, string $fallback, array $parameters = []): string
    {
        if (null === $this->url) {
            return $fallback;
        }

        try {
            return $this->url->generate($route, $parameters);
        } catch (\Throwable) {
            return $fallback;
        }
    }
}
