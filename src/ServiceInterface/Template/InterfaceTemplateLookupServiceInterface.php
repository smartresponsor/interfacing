<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Template;

use App\Interfacing\Contract\Template\InterfaceLocationPayload;
use App\Interfacing\Contract\Template\InterfaceTemplateCandidate;

/**
 * Resolves canonical Interfacing template candidates and view payloads.
 */
interface InterfaceTemplateLookupServiceInterface
{
    public function resolve(string $view, string $operation = 'index'): InterfaceTemplateCandidate;

    /**
     * @param array<string, mixed> $metadata
     */
    public function payloadForView(string $view, string $operation, string $title, array $metadata = []): InterfaceLocationPayload;
}
