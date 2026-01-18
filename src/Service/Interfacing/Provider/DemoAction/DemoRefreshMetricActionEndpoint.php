    <?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace SmartResponsor\Interfacing\Service\Interfacing\Provider\DemoAction;

    use SmartResponsor\Interfacing\Domain\Interfacing\Model\Action\ActionResult;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Action\ActionRequestInterface;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Action\ActionResultInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Action\ActionEndpointInterface;

final class DemoRefreshMetricActionEndpoint implements ActionEndpointInterface
{
    public function screenId(): string
    {
        return 'demo.metric';
    }

    public function actionId(): string
    {
        return 'refresh';
    }

    public function title(): string
    {
        return 'Refresh';
    }

    public function handle(ActionRequestInterface $request): ActionResultInterface
    {
        $v = random_int(0, 100);
        $patch = [
            'metric' => [
                'random' => $v,
                'updatedAt' => (new \DateTimeImmutable())->format(DATE_ATOM),
            ],
        ];

        return ActionResult::ok($patch, [
            ['type' => 'info', 'message' => 'Metric refreshed.'],
        ]);
    }
}

