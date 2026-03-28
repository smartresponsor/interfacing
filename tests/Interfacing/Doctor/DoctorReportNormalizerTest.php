<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace Tests\Interfacing\Doctor;

use App\Service\Interfacing\Doctor\DoctorReportNormalizer;
use PHPUnit\Framework\TestCase;

final class DoctorReportNormalizerTest extends TestCase
{
    public function testNormalize(): void
    {
        $n = new DoctorReportNormalizer();

        $raw = [
            'meta' => ['build' => 'x'],
            'screens' => [
                ['id' => 'b.two', 'title' => 'B'],
                ['id' => 'a.one', 'title' => 'A'],
            ],
            'layouts' => [
                ['id' => 'layout.z'],
                ['id' => 'layout.a'],
            ],
            'issues' => [
                ['warn', 'w.2', 'Second'],
                ['level' => 'error', 'code' => 'e.1', 'text' => 'First'],
                'free form note',
            ],
        ];

        $out = $n->normalize($raw);

        self::assertIsArray($out);
        self::assertArrayHasKey('meta', $out);
        self::assertArrayHasKey('screen', $out);
        self::assertArrayHasKey('layout', $out);
        self::assertArrayHasKey('issue', $out);
        self::assertSame('smartresponsor.interfacing.doctor-report.v1', $out['meta']['schema']);

        // sorted by id
        self::assertSame('a.one', $out['screen'][0]['id']);
        self::assertSame('b.two', $out['screen'][1]['id']);
        self::assertSame('layout.a', $out['layout'][0]['id']);
        self::assertSame('layout.z', $out['layout'][1]['id']);

        // issue normalized + sorted deterministically
        self::assertCount(3, $out['issue']);
        foreach ($out['issue'] as $i) {
            self::assertIsArray($i);
            self::assertArrayHasKey('level', $i);
            self::assertArrayHasKey('code', $i);
            self::assertArrayHasKey('text', $i);
            self::assertIsString($i['level']);
            self::assertIsString($i['code']);
            self::assertIsString($i['text']);
        }

        $k0 = $out['issue'][0]['level'].'|'.$out['issue'][0]['code'].'|'.$out['issue'][0]['text'];
        $k1 = $out['issue'][1]['level'].'|'.$out['issue'][1]['code'].'|'.$out['issue'][1]['text'];
        $k2 = $out['issue'][2]['level'].'|'.$out['issue'][2]['code'].'|'.$out['issue'][2]['text'];
        self::assertTrue($k0 <= $k1 && $k1 <= $k2);
    }
}
