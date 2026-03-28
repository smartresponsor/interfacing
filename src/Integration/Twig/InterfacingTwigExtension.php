<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Integration\Twig;

use App\ServiceInterface\Interfacing\Shell\InterfacingShellInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class InterfacingTwigExtension extends AbstractExtension implements InterfacingTwigExtensionInterface
{
    public function __construct(private readonly InterfacingShellInterface $shell)
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
     * @return \App\Contract\View\ShellView
     */
    public function shell()
    {
        return $this->shell->view();
    }
}
