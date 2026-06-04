<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Provider;

use App\Interfacing\Contract\View\InterfaceLayoutBlockSpec;
use App\Interfacing\Contract\View\InterfaceLayoutScreenSpec;
use App\Interfacing\Contract\View\InterfaceScreenSpec;
use App\Interfacing\ProviderInterface\InterfaceScreenProviderInterface;

final class InterfaceDemoScreenProvider implements InterfaceScreenProviderInterface
{
    /**
     * @return array|\App\Interfacing\Contract\View\InterfaceScreenSpecInterface[]
     */
    public function provide(): array
    {
        $formLayout = new InterfaceLayoutScreenSpec([
            new InterfaceLayoutBlockSpec('form', 'profile', [
                'title' => 'Profile',
                'fields' => [
                    ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'required' => true],
                    ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => true],
                ],
                'actionId' => 'save-profile',
            ]),
        ]);

        $metricLayout = new InterfaceLayoutScreenSpec([
            new InterfaceLayoutBlockSpec('metric', 'health', [
                'title' => 'Random metric',
                'metricKey' => 'random',
                'actionId' => 'refresh',
            ]),
        ]);

        $wizardLayout = new InterfaceLayoutScreenSpec([
            new InterfaceLayoutBlockSpec('wizard', 'setup', [
                'title' => 'Setup wizard',
                'steps' => [
                    ['key' => 'one', 'title' => 'Step 1', 'content' => 'Enter basics.'],
                    ['key' => 'two', 'title' => 'Step 2', 'content' => 'Confirm details.'],
                    ['key' => 'three', 'title' => 'Step 3', 'content' => 'Finish.'],
                ],
                'actionNext' => 'wizard-next',
                'actionBack' => 'wizard-back',
            ]),
        ]);

        return [
            new InterfaceScreenSpec('demo.form', 'Demo form', $formLayout, [
                'form' => ['name' => '', 'email' => ''],
                'fieldError' => [],
                'globalError' => [],
                'flash' => [],
            ]),
            new InterfaceScreenSpec('demo.metric', 'Demo metric', $metricLayout, [
                'metric' => ['random' => 0, 'updatedAt' => null],
                'flash' => [],
            ]),
            new InterfaceScreenSpec('demo.wizard', 'Demo wizard', $wizardLayout, [
                'wizard' => ['step' => 0],
                'flash' => [],
            ]),
        ];
    }
}
