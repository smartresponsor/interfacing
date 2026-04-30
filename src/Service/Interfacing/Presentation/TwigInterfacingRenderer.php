<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Presentation;

use App\Interfacing\ServiceInterface\Interfacing\Presentation\InterfacingRendererInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final readonly class TwigInterfacingRenderer implements InterfacingRendererInterface
{
    public function __construct(private Environment $twig)
    {
    }

    public function render(string $template, array $context = [], int $status = 200): Response
    {
        return new Response($this->twig->render($template, $context), $status);
    }
}
