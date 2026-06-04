<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Integration\Twig;

use App\Interfacing\ServiceInterface\Integration\Twig\InterfaceTwigExtensionInterface;
use App\Interfacing\ServiceInterface\Shell\InterfaceShellInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class InterfaceTwigExtension extends AbstractExtension implements InterfaceTwigExtensionInterface
{
    public function __construct(private readonly InterfaceShellInterface $shell)
    {
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('interfacing_shell', [$this, 'shell']),
        ];
    }

    /**
     * @return \App\Interfacing\Contract\View\InterfaceShellView
     */
    public function shell()
    {
        return $this->shell->view();
    }
}
