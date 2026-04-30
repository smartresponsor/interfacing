<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Presentation\LiveComponent\Interfacing\Screen;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('interfacing_screen_health', template: 'interfacing/screen/health.html.twig')]
final class ScreenHealthComponent implements ScreenHealthComponentInterface
{
    use DefaultActionTrait;

    public function __construct(private readonly ParameterBagInterface $parameter)
    {
    }

    public function __invoke(): void
    {
    }

    public function env(): string
    {
        return (string) $this->parameter->get('kernel.environment');
    }
}
