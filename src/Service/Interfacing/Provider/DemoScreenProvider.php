    <?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace SmartResponsor\Interfacing\Service\Interfacing\Provider;

    use SmartResponsor\Interfacing\Domain\Interfacing\Model\Layout\LayoutBlockSpec;
use SmartResponsor\Interfacing\Domain\Interfacing\Model\Layout\LayoutScreenSpec;
use SmartResponsor\Interfacing\Domain\Interfacing\Model\Screen\ScreenSpec;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Provider\ScreenProviderInterface;

final class DemoScreenProvider implements ScreenProviderInterface
{
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

