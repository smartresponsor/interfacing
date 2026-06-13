<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Twig;

use App\Interfacing\Service\Location\InterfaceLocationRenderService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class InterfaceLocationTwigExtension extends AbstractExtension
{
    public function __construct(
        private readonly InterfaceLocationRenderService $locationRenderService,
    ) {
    }

    /**
     * @return list<TwigFunction>
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('interface_location', [$this, 'renderLocation'], [
                'needs_context' => true,
                'is_safe' => ['html'],
            ]),
            new TwigFunction('interface_locations', [$this, 'locations'], [
                'needs_context' => true,
            ]),
        ];
    }

    /**
     * @param array<string, mixed> $context
     */
    public function renderLocation(array $context, string $locationName): string
    {
        return $this->locationRenderService->render($context, $locationName);
    }

    /**
     * @param array<string, mixed> $context
     *
     * @return array<string, mixed>
     */
    public function locations(array $context): array
    {
        return $this->locationRenderService->locations($context);
    }
}
