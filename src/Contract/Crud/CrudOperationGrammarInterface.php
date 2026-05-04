<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Crud;

/**
 * Describes one canonical CRUD bridge operation and its route grammar.
 *
 * The grammar is intentionally resource-path based and does not know the
 * owning component. Providers and view builders use this contract instead of
 * hardcoding route names and URL patterns in multiple places.
 */
interface CrudOperationGrammarInterface
{
    public function operation(): string;

    public function label(): string;

    public function routeName(): string;

    public function grammar(): string;

    public function variant(): string;

    public function expectedPattern(string $resourcePath): string;

    public function sampleUrl(string $resourcePath, string $sampleIdentifier = 'sample'): string;

    /** @return array<string, string> */
    public function routeParameters(string $resourcePath, string $sampleIdentifier = 'sample'): array;
}
