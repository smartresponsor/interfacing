<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Crud;

final readonly class CrudOperationGrammar implements CrudOperationGrammarInterface
{
    public function __construct(
        private string $operation,
        private string $label,
        private string $routeName,
        private string $grammar,
        private string $variant = 'default',
    ) {
    }

    public function operation(): string
    {
        return $this->operation;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function routeName(): string
    {
        return $this->routeName;
    }

    public function grammar(): string
    {
        return $this->grammar;
    }

    public function variant(): string
    {
        return $this->variant;
    }

    public function expectedPattern(string $resourcePath): string
    {
        return $this->materializeResourcePath($resourcePath);
    }

    public function sampleUrl(string $resourcePath, string $sampleIdentifier = 'sample'): string
    {
        return str_replace('{id}', $sampleIdentifier, $this->materializeResourcePath($resourcePath));
    }

    public function routeParameters(string $resourcePath, string $sampleIdentifier = 'sample'): array
    {
        $parameters = ['resourcePath' => $resourcePath];

        if (str_contains($this->grammar, '{id}')) {
            $parameters['id'] = $sampleIdentifier;
        }

        return $parameters;
    }

    private function materializeResourcePath(string $resourcePath): string
    {
        return str_replace('{resourcePath}', trim($resourcePath, '/'), $this->grammar);
    }
}
