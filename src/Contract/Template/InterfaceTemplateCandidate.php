<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Template;

/**
 * Describes the resolved Interfacing template candidate list for a view.
 */
final readonly class InterfaceTemplateCandidate
{
    /**
     * @param list<string> $candidate
     */
    public function __construct(
        public string $view,
        public string $template,
        public array $candidate,
        public bool $matched,
    ) {
    }
}
