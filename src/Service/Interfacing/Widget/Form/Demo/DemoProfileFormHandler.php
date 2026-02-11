<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Service\Interfacing\Widget\Form\Demo;

use App\Domain\Interfacing\Model\Form\FormFieldSpec;
use App\Domain\Interfacing\Model\Form\FormSpec;
use App\Domain\Interfacing\Model\Form\FormSubmitResult;
use App\ServiceInterface\Interfacing\Widget\Form\FormHandlerInterface;

/**
 *
 */

/**
 *
 */
final class DemoProfileFormHandler implements FormHandlerInterface
{
    /**
     * @return string
     */
    public function id(): string { return 'demo-profile'; }

    /**
     * @param array $context
     * @return \App\Domain\Interfacing\Model\Form\FormSpec
     */
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

    /**
     * @param array $context
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

    /**
     * @param array $value
     * @param array $context
     * @return \App\Domain\Interfacing\Model\Form\FormSubmitResult
     */
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
