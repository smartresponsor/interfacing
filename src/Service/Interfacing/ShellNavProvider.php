<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing;

use App\Interfacing\Contract\View\ShellNavGroup;
use App\Interfacing\ServiceInterface\Interfacing\Shell\ShellChromeProviderInterface;
use App\Interfacing\ServiceInterface\Interfacing\ShellNavProviderInterface;

final class ShellNavProvider implements ShellNavProviderInterface
{
    public function __construct(
        private readonly ShellChromeProviderInterface $chromeProvider,
    ) {
    }

    public function provide(): array
    {
        $chrome = $this->chromeProvider->provide();
        $groups = [];

        foreach (['primaryGroup', 'sectionGroup'] as $key) {
            foreach ($chrome[$key] ?? [] as $group) {
                if ($group instanceof ShellNavGroup) {
                    $groups[] = $group;
                }
            }
        }

        return $groups;
    }
}
