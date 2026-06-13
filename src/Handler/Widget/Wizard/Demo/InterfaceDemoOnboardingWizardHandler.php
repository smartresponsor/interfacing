<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\Handler\Widget\Wizard\Demo;

use App\Interfacing\Contract\Dto\InterfaceFormSubmitResult;
use App\Interfacing\Contract\View\InterfaceFormFieldSpec;
use App\Interfacing\Contract\View\InterfaceWizardSpec;
use App\Interfacing\Contract\View\InterfaceWizardStepSpec;
use App\Interfacing\HandlerInterface\Widget\Wizard\InterfaceWizardHandlerInterface;

final class InterfaceDemoOnboardingWizardHandler implements InterfaceWizardHandlerInterface
{
    public function id(): string
    {
        return 'demo-onboarding';
    }

    public function spec(array $context = []): InterfaceWizardSpec
    {
        $regionDefault = 'us';
        $q = $context['query'] ?? [];
        if (is_array($q) && isset($q['region']) && is_string($q['region'])) {
            $regionDefault = in_array($q['region'], ['us', 'eu'], true) ? $q['region'] : 'us';
        }

        return new InterfaceWizardSpec(
            id: 'demo-onboarding',
            title: 'Onboarding wizard',
            step: [
                new InterfaceWizardStepSpec('account', 'Account', [
                    new InterfaceFormFieldSpec('company', 'Company', 'text', true, 'Marketing America Corp'),
                    new InterfaceFormFieldSpec('plan', 'Plan', 'select', true, '', [
                        ['value' => 'free', 'label' => 'Free'],
                        ['value' => 'pro', 'label' => 'Pro'],
                        ['value' => 'ent', 'label' => 'Enterprise'],
                    ]),
                ], 'Basic tenant settings.'),
                new InterfaceWizardStepSpec('contact', 'Contact', [
                    new InterfaceFormFieldSpec('nameEntity', 'Full nameEntity', 'text', true, 'Oleksandr T.'),
                    new InterfaceFormFieldSpec('email', 'Email', 'email', true, 'dev@example.com'),
                ], 'Main contact person.'),
                new InterfaceWizardStepSpec('policy', 'Policy', [
                    new InterfaceFormFieldSpec('region', 'Region', 'select', true, '', [
                        ['value' => 'us', 'label' => 'United States'],
                        ['value' => 'eu', 'label' => 'Europe'],
                    ]),
                    new InterfaceFormFieldSpec('agree', 'Accept policy', 'checkbox', true),
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
            'nameEntity' => '',
            'email' => '',
            'region' => $region,
            'agree' => false,
        ];
    }

    public function validateStep(string $stepId, array $value, array $context = []): InterfaceFormSubmitResult
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
            if ('' === trim((string) ($value['nameEntity'] ?? ''))) {
                $err['nameEntity'] = 'Name is required.';
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
            return new InterfaceFormSubmitResult(false, 'Please fix validation errors.', $err, $value);
        }

        return new InterfaceFormSubmitResult(true, 'OK', [], $value);
    }

    public function finish(array $value, array $context = []): InterfaceFormSubmitResult
    {
        $value = $this->normalize($value);
        $email = trim((string) ($value['email'] ?? ''));
        if ('' === $email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return new InterfaceFormSubmitResult(false, 'Email is invalid.', ['email' => 'Email is invalid.'], $value);
        }
        if (empty($value['agree'])) {
            return new InterfaceFormSubmitResult(false, 'You must accept policy.', ['agree' => 'You must accept policy.'], $value);
        }

        $msg = 'Created tenant: '.trim((string) ($value['company'] ?? ''));
        $msg .= ' | plan '.($value['plan'] ?? '');
        $msg .= ' | region '.($value['region'] ?? '');
        $msg .= ' | contact '.$email;

        return new InterfaceFormSubmitResult(true, $msg, [], $value);
    }

    /** @param array<string,mixed> $value @return array<string,mixed> */
    private function normalize(array $value): array
    {
        $out = [];
        $out['company'] = is_scalar($value['company'] ?? null) ? (string) $value['company'] : '';
        $out['plan'] = is_scalar($value['plan'] ?? null) ? (string) $value['plan'] : 'free';
        $out['nameEntity'] = is_scalar($value['nameEntity'] ?? null) ? (string) $value['nameEntity'] : '';
        $out['email'] = is_scalar($value['email'] ?? null) ? (string) $value['email'] : '';
        $out['region'] = is_scalar($value['region'] ?? null) ? (string) $value['region'] : 'us';
        $a = $value['agree'] ?? null;
        $out['agree'] = (true === $a) || ('1' === $a) || (1 === $a) || ('on' === $a);

        return $out;
    }
}
