<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\Infra\Interfacing\Live\Screen;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent('interfacing_screen_health', template: 'interfacing/screen/health.html.twig')]
final class ScreenHealthComponent implements ScreenHealthComponentInterface
{
    public function __construct(private ParameterBagInterface $parameter)
    {
    }

    public function env(): string
    {
        return (string) $this->parameter->get('kernel.environment');
    }
}
