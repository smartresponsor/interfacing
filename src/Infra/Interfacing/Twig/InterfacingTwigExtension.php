<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\Infra\Interfacing\Twig;

use SmartResponsor\Interfacing\InfraInterface\Interfacing\Twig\InterfacingTwigExtensionInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Shell\InterfacingShellInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class InterfacingTwigExtension extends AbstractExtension implements InterfacingTwigExtensionInterface
{
    public function __construct(private InterfacingShellInterface $shell)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('interfacing_shell', [$this, 'shell']),
        ];
    }

    public function shell()
    {
        return $this->shell->view();
    }
}
