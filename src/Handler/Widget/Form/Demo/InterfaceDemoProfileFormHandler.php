<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Handler\Widget\Form\Demo;

use App\Interfacing\Contract\Dto\InterfaceFormSubmitResult;
use App\Interfacing\Contract\View\InterfaceFormFieldSpec;
use App\Interfacing\Contract\View\InterfaceFormSpec;
use App\Interfacing\HandlerInterface\Widget\Form\InterfaceFormHandlerInterface;

final class InterfaceDemoProfileFormHandler implements InterfaceFormHandlerInterface
{
    public function id(): string
    {
        return 'demo-profile';
    }

    public function spec(array $context = []): InterfaceFormSpec
    {
        $who = (string) ($context['user']['label'] ?? '');
        $hint = 'Demo form handler. Validation happens on the server.';
        if ('' !== $who) {
            $hint .= ' Viewer: '.$who;
        }

        return new InterfaceFormSpec(
            id: 'demo-profile',
            title: 'Profile',
            field: [
                new InterfaceFormFieldSpec('name', 'Name', 'text', true, 'John Doe'),
                new InterfaceFormFieldSpec('email', 'Email', 'email', true, 'john@example.com'),
                new InterfaceFormFieldSpec('status', 'Status', 'select', true, '', [
                    ['value' => 'active', 'label' => 'Active'],
                    ['value' => 'paused', 'label' => 'Paused'],
                    ['value' => 'blocked', 'label' => 'Blocked'],
                ]),
                new InterfaceFormFieldSpec('note', 'Note', 'textarea', false, 'Optional note...'),
                new InterfaceFormFieldSpec('notify', 'Notify by email', 'checkbox', false),
            ],
            submitLabel: 'Save',
            hint: $hint,
        );
    }

    /**
     * @return array|mixed[]
     */
    public function initialValue(array $context = []): array
    {
        return [
            'name' => 'Demo user',
            'email' => 'demo@example.com',
            'status' => 'active',
            'note' => '',
            'notify' => false,
        ];
    }

    public function submit(array $value, array $context = []): InterfaceFormSubmitResult
    {
        $fieldError = [];
        $name = trim((string) ($value['name'] ?? ''));
        $email = trim((string) ($value['email'] ?? ''));
        $status = (string) ($value['status'] ?? '');
        $notify = ($value['notify'] ?? null) === true || ($value['notify'] ?? null) === 'on' || ($value['notify'] ?? null) === '1' || ($value['notify'] ?? null) === 1;

        if ('' === $name) {
            $fieldError['name'] = 'Name is required.';
        }
        if ('' === $email) {
            $fieldError['email'] = 'Email is required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $fieldError['email'] = 'Email is invalid.';
        }
        if (!in_array($status, ['active', 'paused', 'blocked'], true)) {
            $fieldError['status'] = 'Status is invalid.';
        }

        $value['notify'] = $notify;

        if ([] !== $fieldError) {
            return new InterfaceFormSubmitResult(false, 'Please fix validation errors.', $fieldError, $value);
        }

        $msg = 'Saved: '.$name.' ('.$email.')';
        if ($notify) {
            $msg .= ' | notify enabled';
        }

        return new InterfaceFormSubmitResult(true, $msg, [], $value);
    }
}
