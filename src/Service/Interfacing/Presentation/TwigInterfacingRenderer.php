<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Presentation;

use App\Interfacing\ServiceInterface\Interfacing\Presentation\InterfacingRendererInterface;
use App\Interfacing\ServiceInterface\Interfacing\Shell\ShellChromeProviderInterface;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final readonly class TwigInterfacingRenderer implements InterfacingRendererInterface
{
    public function __construct(
        private Environment $twig,
        private ShellChromeProviderInterface $shellChromeProvider,
    ) {
    }

    public function render(string $template, array $context = [], int $status = 200): Response
    {
        $activeId = isset($context['screenId']) && is_string($context['screenId']) ? $context['screenId'] : null;

        if (!array_key_exists('shell', $context) || null === $context['shell']) {
            $context['shell'] = $this->shellChromeProvider->provide($activeId);
        }

        if (!array_key_exists('shellKnownCrudResources', $context) && is_array($context['shell'])) {
            $context['shellKnownCrudResources'] = $context['shell']['knownCrudResources'] ?? [];
        }

        return new Response($this->twig->render($template, $context), $status);
    }
}
