<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Infra\Interfacing\Twig;

use App\InfraInterface\Interfacing\Twig\InterfacingTwigExtensionInterface;
use App\ServiceInterface\Interfacing\Shell\InterfacingShellInterface;
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
