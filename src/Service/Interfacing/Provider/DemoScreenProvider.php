<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Service\Interfacing\Provider;

use App\Interfacing\Contract\View\LayoutBlockSpec;
use App\Interfacing\Contract\View\LayoutScreenSpec;
use App\Interfacing\Contract\View\ScreenSpec;
use App\Interfacing\ServiceInterface\Interfacing\Provider\ScreenProviderInterface;

final class DemoScreenProvider implements ScreenProviderInterface
{
    /**
     * @return array|\App\Interfacing\Contract\View\ScreenSpecInterface[]
     */
    public function provide(): array
    {
        $formLayout = new LayoutScreenSpec([
            new LayoutBlockSpec('form', 'profile', [
                'title' => 'Profile',
                'fields' => [
                    ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'required' => true],
                    ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => true],
                ],
                'actionId' => 'save-profile',
            ]),
        ]);

        $metricLayout = new LayoutScreenSpec([
            new LayoutBlockSpec('metric', 'health', [
                'title' => 'Random metric',
                'metricKey' => 'random',
                'actionId' => 'refresh',
            ]),
        ]);

        $wizardLayout = new LayoutScreenSpec([
            new LayoutBlockSpec('wizard', 'setup', [
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
            new ScreenSpec('demo.form', 'Demo form', $formLayout, [
                'form' => ['name' => '', 'email' => ''],
                'fieldError' => [],
                'globalError' => [],
                'flash' => [],
            ]),
            new ScreenSpec('demo.metric', 'Demo metric', $metricLayout, [
                'metric' => ['random' => 0, 'updatedAt' => null],
                'flash' => [],
            ]),
            new ScreenSpec('demo.wizard', 'Demo wizard', $wizardLayout, [
                'wizard' => ['step' => 0],
                'flash' => [],
            ]),
        ];
    }
}
