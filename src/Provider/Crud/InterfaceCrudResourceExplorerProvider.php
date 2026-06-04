<?php

declare(strict_types=1);

namespace App\Interfacing\Provider\Crud;

use App\Interfacing\Contract\Crud\InterfaceCrudOperationGrammarInterface;
use App\Interfacing\Contract\Crud\InterfaceCrudResourceDescriptorInterface;
use App\Interfacing\Contract\View\InterfaceCrudResourceLinkSet;
use App\Interfacing\Contract\View\InterfaceCrudResourceLinkSetInterface;
use App\Interfacing\ContributionInterface\Crud\InterfaceCrudResourceDescriptorContributionInterface;
use App\Interfacing\ProviderInterface\Crud\InterfaceCrudOperationGrammarProviderInterface;
use App\Interfacing\ProviderInterface\Crud\InterfaceCrudResourceExplorerProviderInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

final readonly class InterfaceCrudResourceExplorerProvider implements InterfaceCrudResourceExplorerProviderInterface
{
    /** @param iterable<InterfaceCrudResourceDescriptorContributionInterface> $contributions */
    public function __construct(
        private iterable $contributions,
        private InterfaceCrudOperationGrammarProviderInterface $operationGrammarProvider,
        #[Autowire(service: 'cache.app.recorder_inner')]
        private CacheInterface $cache,
        private ?UrlGeneratorInterface $url = null,
    ) {
    }

    public function provide(): array
    {
        return $this->cache->get('interfacing.crud.resource-explorer.v1', function (ItemInterface $item): array {
            $item->expiresAfter(3600);

            return $this->build();
        });
    }

    /**
     * @return list<InterfaceCrudResourceLinkSetInterface>
     */
    private function build(): array
    {
        /** @var array<string, InterfaceCrudResourceLinkSetInterface> $byId */
        $byId = [];

        foreach ($this->contributions as $contribution) {
            if (!$contribution instanceof InterfaceCrudResourceDescriptorContributionInterface) {
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
            static fn (InterfaceCrudResourceLinkSetInterface $left, InterfaceCrudResourceLinkSetInterface $right): int => [
                $left->component(),
                $left->label(),
                $left->id(),
            ] <=> [
                $right->component(),
                $right->label(),
                $right->id(),
            ],
        );

        return $list;
    }

    private function normalizeResource(object $resource): ?InterfaceCrudResourceLinkSetInterface
    {
        if ($resource instanceof InterfaceCrudResourceLinkSetInterface) {
            return $resource;
        }

        if (!$resource instanceof InterfaceCrudResourceDescriptorInterface) {
            return null;
        }

        $show = $this->operation('show');
        $edit = $this->operation('edit');
        $delete = $this->operation('delete');

        return new InterfaceCrudResourceLinkSet(
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

    private function operation(string $operation): ?InterfaceCrudOperationGrammarInterface
    {
        return $this->operationGrammarProvider->get($operation);
    }

    /**
     * @param array<string, string> $routeParameters
     */
    private function safeOperationUrl(?InterfaceCrudOperationGrammarInterface $operation, string $resourcePath, string $sampleIdentifier, string $fallback, array $routeParameters = []): string
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

    private function priority(InterfaceCrudResourceLinkSetInterface $resource): int
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
