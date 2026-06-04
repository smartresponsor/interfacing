<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Service\Layout;

use App\Interfacing\Contract\View\InterfaceLayoutScreenSpec;
use App\Interfacing\ServiceInterface\Layout\InterfaceLayoutShellInterface;

final class InterfaceLayoutShellService implements InterfaceLayoutShellInterface
{
    /**
     * @return array|mixed[]
     */
    public function build(InterfaceLayoutScreenSpec $activeSpec, array $allSpec): array
    {
        $navGroupTitle = [
            'tool' => 'Tool',
            'message' => 'Messaging',
            'ops' => 'Ops',
            'data' => 'Data',
            'security' => 'Security',
            'audit' => 'Audit',
        ];

        $groups = [];
        foreach ($allSpec as $spec) {
            if (!$spec instanceof InterfaceLayoutScreenSpec) {
                continue;
            }
            $groups[$spec->navGroup()][] = $spec;
        }

        ksort($groups);
        foreach ($groups as $k => $items) {
            usort($items, static fn (InterfaceLayoutScreenSpec $a, InterfaceLayoutScreenSpec $b): int => strcmp($a->title(), $b->title()));
            $groups[$k] = $items;
        }

        return [
            'active' => $activeSpec,
            'spec' => $allSpec,
            'navGroupTitle' => $navGroupTitle,
            'navGroup' => $groups,
        ];
    }
}
