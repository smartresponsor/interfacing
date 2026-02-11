<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace App\Service\Interfacing\Provider\DemoAction;

    use App\Domain\Interfacing\Model\Action\ActionResult;
use App\DomainInterface\Interfacing\Model\Action\ActionRequestInterface;
use App\DomainInterface\Interfacing\Model\Action\ActionResultInterface;
use App\ServiceInterface\Interfacing\Action\ActionEndpointInterface;

    /**
     *
     */

    /**
     *
     */
    final class DemoRefreshMetricActionEndpoint implements ActionEndpointInterface
{
    /**
     * @return string
     */
    public function screenId(): string
    {
        return 'demo.metric';
    }

    /**
     * @return string
     */
    public function actionId(): string
    {
        return 'refresh';
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Refresh';
    }

    /**
     * @param \App\DomainInterface\Interfacing\Model\Action\ActionRequestInterface $request
     * @return \App\DomainInterface\Interfacing\Model\Action\ActionResultInterface
     * @throws \Random\RandomException
     */
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

