<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Template;

use App\Interfacing\Contract\Template\InterfaceLocationPayload;
use App\Interfacing\Contract\Template\InterfaceTemplateCandidate;

/**
 * Resolves canonical Interfacing template candidates and surface payloads.
 */
interface InterfaceTemplateLookupServiceInterface
{
    public function resolve(string $surface, string $operation = 'index'): InterfaceTemplateCandidate;

    /**
     * @param array<string, mixed> $metadata
     */
    public function payloadForSurface(string $surface, string $operation, string $title, array $metadata = []): InterfaceLocationPayload;
}
