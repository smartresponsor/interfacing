<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\Service\Interfacing\Doctor;

use App\Interfacing\ServiceInterface\Interfacing\Doctor\DoctorReportNormalizerInterface;

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

        usort($screen, static fn (array $a, array $b): int => ((string) ($a['id'] ?? '')) <=> ((string) ($b['id'] ?? '')));
        usort($layout, static fn (array $a, array $b): int => ((string) ($a['id'] ?? '')) <=> ((string) ($b['id'] ?? '')));

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

    /**
     * @return list<array{level:string,code:string,text:string}>
     */
    private function normalizeIssue(mixed $value): array
    {
        if (!\is_array($value)) {
            return [];
        }

        $issue = [];

        foreach ($value as $item) {
            if (\is_array($item) && isset($item['level'], $item['code'], $item['text'])) {
                $issue[] = [
                    'level' => (string) $item['level'],
                    'code' => (string) $item['code'],
                    'text' => (string) $item['text'],
                ];

                continue;
            }

            if (\is_array($item) && isset($item[0], $item[1], $item[2])) {
                $issue[] = [
                    'level' => (string) $item[0],
                    'code' => (string) $item[1],
                    'text' => (string) $item[2],
                ];

                continue;
            }

            $text = trim((string) $item);
            if ('' === $text) {
                continue;
            }

            $issue[] = [
                'level' => 'info',
                'code' => 'note',
                'text' => $text,
            ];
        }

        usort($issue, static fn (array $a, array $b): int => [$a['level'], $a['code'], $a['text']] <=> [$b['level'], $b['code'], $b['text']]);

        return $issue;
    }
}
