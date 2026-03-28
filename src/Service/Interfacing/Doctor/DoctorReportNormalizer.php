<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Service\Interfacing\Doctor;

use App\ServiceInterface\Interfacing\Doctor\DoctorReportNormalizerInterface;

final class DoctorReportNormalizer implements DoctorReportNormalizerInterface
{
    public function normalize(array $raw): array
    {
        $meta = $this->arrayOrEmpty($raw['meta'] ?? []);
        $screen = $this->arrayOrEmpty($raw['screen'] ?? $raw['screens'] ?? []);
        $layout = $this->arrayOrEmpty($raw['layout'] ?? $raw['layouts'] ?? []);
        $issue = $this->normalizeIssue($raw['issue'] ?? $raw['issues'] ?? []);

        // Back-compat: some builders provide nested report structures.
        if ([] === $screen && isset($raw['registry']['screen'])) {
            $screen = $this->arrayOrEmpty($raw['registry']['screen']);
        }
        if ([] === $layout && isset($raw['registry']['layout'])) {
            $layout = $this->arrayOrEmpty($raw['registry']['layout']);
        }
        if ([] === $issue && isset($raw['check']['issue'])) {
            $issue = $this->arrayOrEmpty($raw['check']['issue']);
        }

        $meta += [
            'schema' => 'smartresponsor.interfacing.doctor-report.v1',
        ];

        return [
            'meta' => $meta,
            'screen' => $screen,
            'layout' => $layout,
            'issue' => $issue,
        ];
    }

    private function arrayOrEmpty(mixed $v): array
    {
        return \is_array($v) ? $v : [];
    }
}
