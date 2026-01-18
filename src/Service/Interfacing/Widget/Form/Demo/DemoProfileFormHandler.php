<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\Service\Interfacing\Widget\Form\Demo;

use SmartResponsor\Interfacing\Domain\Interfacing\Model\Form\FormFieldSpec;
use SmartResponsor\Interfacing\Domain\Interfacing\Model\Form\FormSpec;
use SmartResponsor\Interfacing\Domain\Interfacing\Model\Form\FormSubmitResult;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Widget\Form\FormHandlerInterface;

final class DemoProfileFormHandler implements FormHandlerInterface
{
    public function id(): string { return 'demo-profile'; }

    public function spec(array $context = []): FormSpec
    {
        $who = (string)($context['user']['label'] ?? '');
        $hint = 'Demo form handler. Validation happens on the server.';
        if ($who !== '') {
            $hint .= ' Viewer: '.$who;
        }

        return new FormSpec(
            id: 'demo-profile',
            title: 'Profile',
            field: [
                new FormFieldSpec('name', 'Name', 'text', true, 'John Doe'),
                new FormFieldSpec('email', 'Email', 'email', true, 'john@example.com'),
                new FormFieldSpec('status', 'Status', 'select', true, '', [
                    ['value' => 'active', 'label' => 'Active'],
                    ['value' => 'paused', 'label' => 'Paused'],
                    ['value' => 'blocked', 'label' => 'Blocked'],
                ]),
                new FormFieldSpec('note', 'Note', 'textarea', false, 'Optional note...'),
                new FormFieldSpec('notify', 'Notify by email', 'checkbox', false),
            ],
            submitLabel: 'Save',
            hint: $hint,
        );
    }

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

    public function submit(array $value, array $context = []): FormSubmitResult
    {
        $fieldError = [];
        $name = trim((string)($value['name'] ?? ''));
        $email = trim((string)($value['email'] ?? ''));
        $status = (string)($value['status'] ?? '');
        $notify = ($value['notify'] ?? null) === true || ($value['notify'] ?? null) === 'on' || ($value['notify'] ?? null) === '1' || ($value['notify'] ?? null) === 1;

        if ($name === '') { $fieldError['name'] = 'Name is required.'; }
        if ($email === '') { $fieldError['email'] = 'Email is required.'; }
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $fieldError['email'] = 'Email is invalid.'; }
        if (!in_array($status, ['active','paused','blocked'], true)) { $fieldError['status'] = 'Status is invalid.'; }

        $value['notify'] = $notify;

        if ($fieldError !== []) {
            return new FormSubmitResult(false, 'Please fix validation errors.', $fieldError, $value);
        }

        $msg = 'Saved: '.$name.' ('.$email.')';
        if ($notify) { $msg .= ' | notify enabled'; }
        return new FormSubmitResult(true, $msg, [], $value);
    }
}
