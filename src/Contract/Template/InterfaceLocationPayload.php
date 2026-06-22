<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Template;

/**
 * Neutral location-based payload passed to Interfacing templates.
 */
final readonly class InterfaceLocationPayload
{
    /**
     * @param array<string, list<array<string, mixed>>> $location
     * @param array<string, mixed>                      $metadata
     */
    public function __construct(
        public string $view,
        public InterfaceTemplateCandidate $candidate,
        public array $location,
        public array $metadata = [],
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'view' => $this->view,
            'candidate' => [
                'view' => $this->candidate->view,
                'template' => $this->candidate->template,
                'candidate' => $this->candidate->candidate,
                'matched' => $this->candidate->matched,
            ],
            'location' => $this->location,
            'metadata' => $this->metadata,
        ];
    }
}
