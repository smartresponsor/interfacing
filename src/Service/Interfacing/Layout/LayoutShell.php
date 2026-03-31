<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Service\Interfacing\Layout;

use App\Contract\View\LayoutScreenSpec;
use App\ServiceInterface\Interfacing\Layout\LayoutShellInterface;

final class LayoutShell implements LayoutShellInterface
{
    /**
     * @return array|mixed[]
     */
    public function build(LayoutScreenSpec $activeSpec, array $allSpec): array
    {
        $navGroupTitle = [
            'tool' => 'Tool',
            'ops' => 'Ops',
            'data' => 'Data',
            'security' => 'Security',
            'audit' => 'Audit',
        ];

        $groups = [];
        foreach ($allSpec as $spec) {
            if (!$spec instanceof LayoutScreenSpec) {
                continue;
            }
            $groups[$spec->navGroup()][] = $spec;
        }

        ksort($groups);
        foreach ($groups as $k => $items) {
            usort($items, static fn (LayoutScreenSpec $a, LayoutScreenSpec $b): int => strcmp($a->title(), $b->title()));
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
