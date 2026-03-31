<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Service\Interfacing\Provider\DemoAction;

use App\ServiceInterface\Interfacing\Registry\ActionEndpointInterface;
use App\ServiceInterface\Interfacing\Runtime\ActionRequest;
use App\ServiceInterface\Interfacing\Runtime\ActionResult;

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

    public function order(): int
    {
        return 100;
    }

    /**
     * @throws \Random\RandomException
     */
    public function handle(ActionRequest $request): ActionResult
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
