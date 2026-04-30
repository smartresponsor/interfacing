<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Service\Interfacing\Provider\DemoAction;

use App\Interfacing\ServiceInterface\Interfacing\Registry\ActionEndpointInterface;
use App\Interfacing\ServiceInterface\Interfacing\Runtime\ActionRequest;
use App\Interfacing\ServiceInterface\Interfacing\Runtime\ActionResult;

final class DemoSaveProfileActionEndpoint implements ActionEndpointInterface
{
    public function screenId(): string
    {
        return 'demo.form';
    }

    public function actionId(): string
    {
        return 'save-profile';
    }

    public function title(): string
    {
        return 'Save profile';
    }

    public function order(): int
    {
        return 100;
    }

    public function handle(ActionRequest $request): ActionResult
    {
        $payload = $request->payload();
        $name = isset($payload['name']) ? trim((string) $payload['name']) : '';
        $email = isset($payload['email']) ? trim((string) $payload['email']) : '';

        $fieldError = [];
        $globalError = [];

        if ('' === $name) {
            $fieldError['name'] = 'Name is required.';
        }
        if ('' === $email) {
            $fieldError['email'] = 'Email is required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $fieldError['email'] = 'Email is invalid.';
        }

        if ([] !== $fieldError) {
            return ActionResult::validationError($fieldError, $globalError);
        }

        $statePatch = [
            'form' => ['name' => $name, 'email' => $email],
            'fieldError' => [],
            'globalError' => [],
        ];

        return ActionResult::ok($statePatch, [
            ['type' => 'success', 'message' => 'Saved.'],
        ]);
    }
}
