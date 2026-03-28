<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Service\Interfacing\Widget\Wizard\Demo;

use App\Contract\Dto\FormSubmitResult;
use App\Contract\View\FormFieldSpec;
use App\Contract\View\WizardSpec;
use App\Contract\View\WizardStepSpec;
use App\ServiceInterface\Interfacing\Widget\Wizard\WizardHandlerInterface;

final class DemoOnboardingWizardHandler implements WizardHandlerInterface
{
    public function id(): string
    {
        return 'demo-onboarding';
    }

    public function spec(array $context = []): WizardSpec
    {
        $regionDefault = 'us';
        $q = $context['query'] ?? [];
        if (is_array($q) && isset($q['region']) && is_string($q['region'])) {
            $regionDefault = in_array($q['region'], ['us', 'eu'], true) ? $q['region'] : 'us';
        }

        return new WizardSpec(
            id: 'demo-onboarding',
            title: 'Onboarding wizard',
            step: [
                new WizardStepSpec('account', 'Account', [
                    new FormFieldSpec('company', 'Company', 'text', true, 'Marketing America Corp'),
                    new FormFieldSpec('plan', 'Plan', 'select', true, '', [
                        ['value' => 'free', 'label' => 'Free'],
                        ['value' => 'pro', 'label' => 'Pro'],
                        ['value' => 'ent', 'label' => 'Enterprise'],
                    ]),
                ], 'Basic tenant settings.'),
                new WizardStepSpec('contact', 'Contact', [
                    new FormFieldSpec('name', 'Full name', 'text', true, 'Oleksandr T.'),
                    new FormFieldSpec('email', 'Email', 'email', true, 'dev@example.com'),
                ], 'Main contact person.'),
                new WizardStepSpec('policy', 'Policy', [
                    new FormFieldSpec('region', 'Region', 'select', true, '', [
                        ['value' => 'us', 'label' => 'United States'],
                        ['value' => 'eu', 'label' => 'Europe'],
                    ]),
                    new FormFieldSpec('agree', 'Accept policy', 'checkbox', true),
                ], 'Compliance toggle.'),
            ],
            finishLabel: 'Create tenant',
            cancelLabel: 'Cancel',
        );
    }

    /**
     * @return array|mixed[]
     */
    public function initialValue(array $context = []): array
    {
        $region = 'us';
        $q = $context['query'] ?? [];
        if (is_array($q) && isset($q['region']) && is_string($q['region'])) {
            $region = in_array($q['region'], ['us', 'eu'], true) ? $q['region'] : 'us';
        }

        return [
            'company' => 'Marketing America Corp',
            'plan' => 'pro',
            'name' => '',
            'email' => '',
            'region' => $region,
            'agree' => false,
        ];
    }

    public function validateStep(string $stepId, array $value, array $context = []): FormSubmitResult
    {
        $value = $this->normalize($value);
        $err = [];

        if ('account' === $stepId) {
            if ('' === trim((string) ($value['company'] ?? ''))) {
                $err['company'] = 'Company is required.';
            }
            if (!in_array((string) ($value['plan'] ?? ''), ['free', 'pro', 'ent'], true)) {
                $err['plan'] = 'Plan is invalid.';
            }
        }

        if ('contact' === $stepId) {
            if ('' === trim((string) ($value['name'] ?? ''))) {
                $err['name'] = 'Name is required.';
            }
            $email = trim((string) ($value['email'] ?? ''));
            if ('' === $email) {
                $err['email'] = 'Email is required.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $err['email'] = 'Email is invalid.';
            }
        }

        if ('policy' === $stepId) {
            if (!in_array((string) ($value['region'] ?? ''), ['us', 'eu'], true)) {
                $err['region'] = 'Region is invalid.';
            }
            if (empty($value['agree'])) {
                $err['agree'] = 'You must accept policy.';
            }
        }

        if ([] !== $err) {
            return new FormSubmitResult(false, 'Please fix validation errors.', $err, $value);
        }

        return new FormSubmitResult(true, 'OK', [], $value);
    }

    public function finish(array $value, array $context = []): FormSubmitResult
    {
        $value = $this->normalize($value);
        $email = trim((string) ($value['email'] ?? ''));
        if ('' === $email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return new FormSubmitResult(false, 'Email is invalid.', ['email' => 'Email is invalid.'], $value);
        }
        if (empty($value['agree'])) {
            return new FormSubmitResult(false, 'You must accept policy.', ['agree' => 'You must accept policy.'], $value);
        }

        $msg = 'Created tenant: '.trim((string) ($value['company'] ?? ''));
        $msg .= ' | plan '.($value['plan'] ?? '');
        $msg .= ' | region '.($value['region'] ?? '');
        $msg .= ' | contact '.$email;

        return new FormSubmitResult(true, $msg, [], $value);
    }

    /** @param array<string,mixed> $value @return array<string,mixed> */
    private function normalize(array $value): array
    {
        $out = [];
        $out['company'] = is_scalar($value['company'] ?? null) ? (string) $value['company'] : '';
        $out['plan'] = is_scalar($value['plan'] ?? null) ? (string) $value['plan'] : 'free';
        $out['name'] = is_scalar($value['name'] ?? null) ? (string) $value['name'] : '';
        $out['email'] = is_scalar($value['email'] ?? null) ? (string) $value['email'] : '';
        $out['region'] = is_scalar($value['region'] ?? null) ? (string) $value['region'] : 'us';
        $a = $value['agree'] ?? null;
        $out['agree'] = (true === $a) || ('1' === $a) || (1 === $a) || ('on' === $a);

        return $out;
    }
}
