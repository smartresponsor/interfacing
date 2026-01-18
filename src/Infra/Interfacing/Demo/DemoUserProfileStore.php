<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Infra\Interfacing\Demo;

use App\Domain\Interfacing\Error\DomainOperationFailed;
use App\InfraInterface\Interfacing\Demo\DemoUserProfileStoreInterface;

final class DemoUserProfileStore implements DemoUserProfileStoreInterface
{
    private const BLOCKED_EMAIL = 'blocked@example.com';

    public function __construct(private readonly string $path)
    {
    }

    public function load(): array
    {
        if (!is_file($this->path)) {
            return ['name' => 'Demo User', 'email' => 'demo@example.com'];
        }

        $raw = file_get_contents($this->path);
        if ($raw === false) {
            return ['name' => 'Demo User', 'email' => 'demo@example.com'];
        }

        $data = json_decode($raw, true);
        if (!is_array($data)) {
            return ['name' => 'Demo User', 'email' => 'demo@example.com'];
        }

        return [
            'name' => (string) ($data['name'] ?? 'Demo User'),
            'email' => (string) ($data['email'] ?? 'demo@example.com'),
        ];
    }

    public function save(string $name, string $email): void
    {
        if (mb_strtolower(trim($email)) === self::BLOCKED_EMAIL) {
            throw new DomainOperationFailed('Email is blocked by demo policy.', [
                'email' => 'This email is not allowed.',
            ]);
        }

        $dir = dirname($this->path);
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }

        $payload = json_encode(['name' => $name, 'email' => $email], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        if ($payload === false) {
            throw new DomainOperationFailed('Failed to encode profile payload.');
        }

        $ok = @file_put_contents($this->path, $payload);
        if ($ok === false) {
            throw new DomainOperationFailed('Failed to write profile storage.');
        }
    }
}
