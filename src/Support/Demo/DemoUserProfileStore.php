<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\Support\Demo;

use App\Interfacing\Contract\Error\DomainOperationFailed;
use App\Interfacing\ServiceInterface\Support\Demo\DemoUserProfileStoreInterface;

final class DemoUserProfileStore implements DemoUserProfileStoreInterface
{
    private const BLOCKED_EMAIL = 'blocked@example.com';

    public function __construct(private readonly string $path)
    {
    }

    /**
     * @return string[]
     */
    public function load(): array
    {
        if (!is_file($this->path)) {
            return ['name' => 'Demo User', 'email' => 'demo@example.com'];
        }

        $raw = file_get_contents($this->path);
        if (false === $raw) {
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
        if (self::BLOCKED_EMAIL === mb_strtolower(trim($email))) {
            throw new DomainOperationFailed('Email is blocked by demo policy.', ['email' => 'This email is not allowed.']);
        }

        $dir = dirname($this->path);
        if (!is_dir($dir)) {
            $mkdirError = null;
            set_error_handler(static function (int $severity, string $message) use (&$mkdirError): bool {
                $mkdirError = $message;

                return true;
            });

            $created = mkdir($dir, 0775, true);
            restore_error_handler();

            if (!$created && !is_dir($dir)) {
                throw new DomainOperationFailed('Failed to create profile directory.', ['dir' => $dir, 'error' => $mkdirError]);
            }
        }

        $payload = json_encode(['name' => $name, 'email' => $email], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        if (false === $payload) {
            throw new DomainOperationFailed('Failed to encode profile payload.');
        }

        $writeError = null;
        set_error_handler(static function (int $severity, string $message) use (&$writeError): bool {
            $writeError = $message;

            return true;
        });

        $ok = file_put_contents($this->path, $payload);
        restore_error_handler();

        if (false === $ok) {
            throw new DomainOperationFailed('Failed to write profile storage.', ['error' => $writeError]);
        }
    }
}
