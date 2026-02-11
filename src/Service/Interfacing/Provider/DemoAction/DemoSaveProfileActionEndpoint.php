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
    final class DemoSaveProfileActionEndpoint implements ActionEndpointInterface
{
    /**
     * @return string
     */
    public function screenId(): string
    {
        return 'demo.form';
    }

    /**
     * @return string
     */
    public function actionId(): string
    {
        return 'save-profile';
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Save profile';
    }

    /**
     * @param \App\DomainInterface\Interfacing\Model\Action\ActionRequestInterface $request
     * @return \App\DomainInterface\Interfacing\Model\Action\ActionResultInterface
     */
    public function handle(ActionRequestInterface $request): ActionResultInterface
    {
        $payload = $request->payload();
        $name = isset($payload['name']) ? trim((string) $payload['name']) : '';
        $email = isset($payload['email']) ? trim((string) $payload['email']) : '';

        $fieldError = [];
        $globalError = [];

        if ($name === '') {
            $fieldError['name'] = 'Name is required.';
        }
        if ($email === '') {
            $fieldError['email'] = 'Email is required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $fieldError['email'] = 'Email is invalid.';
        }

        if ($fieldError !== []) {
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

