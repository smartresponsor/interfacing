<?php

declare(strict_types=1);

namespace App\Interfacing\Provider\Shell;

use App\Interfacing\Contract\View\InterfaceShellNavGroup;
use App\Interfacing\Contract\View\InterfaceShellNavItem;
use App\Interfacing\ProviderInterface\Shell\InterfaceShellChromeProviderInterface;
use App\Interfacing\ProviderInterface\Shell\InterfaceShellNavProviderInterface;

final class InterfaceShellNavProvider implements InterfaceShellNavProviderInterface
{
    public function __construct(
        private readonly InterfaceShellChromeProviderInterface $chromeProvider,
    ) {
    }

    public function provide(): array
    {
        $chrome = $this->chromeProvider->provide();
        $locations = is_array($chrome['navigation']['locations'] ?? null) ? $chrome['navigation']['locations'] : [];
        $groups = [];

        foreach ($locations as $locationKey => $items) {
            if (!is_iterable($items) || [] === $items) {
                continue;
            }

            $groupItems = [];
            foreach ($items as $item) {
                if (!is_array($item)) {
                    continue;
                }

                $groupItems[] = new InterfaceShellNavItem(
                    (string) ($item['key'] ?? $item['id'] ?? uniqid('nav.', true)),
                    (string) ($item['label'] ?? $item['title'] ?? 'Item'),
                    (string) ($item['url'] ?? $item['href'] ?? '#'),
                    (string) ($item['group'] ?? $locationKey),
                    isset($item['metadata']['icon']) ? (string) $item['metadata']['icon'] : null,
                    (int) ($item['priority'] ?? $item['order'] ?? 100),
                );
            }

            if ([] === $groupItems) {
                continue;
            }

            $groups[] = new InterfaceShellNavGroup(
                $locationKey,
                match ($locationKey) {
                    'shell.left.middle' => 'Primary navigation',
                    'shell.context.middle' => 'Context navigation',
                    default => $locationKey,
                },
                $groupItems,
            );
        }

        return $groups;
    }
}
