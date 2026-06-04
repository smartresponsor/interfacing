<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Endpoint\Provider\DemoAction;

use App\Interfacing\Contract\Runtime\InterfaceActionRequest;
use App\Interfacing\Contract\Runtime\InterfaceActionResult;
use App\Interfacing\EndpointInterface\AttributeRegistry\InterfaceActionEndpointInterface;

final class InterfaceDemoRefreshMetricActionEndpoint implements InterfaceActionEndpointInterface
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
    public function handle(InterfaceActionRequest $request): InterfaceActionResult
    {
        $v = random_int(0, 100);
        $patch = [
            'metric' => [
                'random' => $v,
                'updatedAt' => (new \DateTimeImmutable())->format(DATE_ATOM),
            ],
        ];

        return InterfaceActionResult::ok($patch, [
            ['type' => 'info', 'message' => 'Metric refreshed.'],
        ]);
    }
}
