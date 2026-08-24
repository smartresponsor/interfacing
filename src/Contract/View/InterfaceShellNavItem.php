<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Contract\View;

final class InterfaceShellNavItem implements InterfaceShellNavItemInterface
{
    public function __construct(
        private string $id,
        private readonly string $title,
        private string $url,
        private string $group,
        private readonly ?string $icon = null,
        private int $order = 100,
    ) {
        $this->id = trim($this->id);
        if ('' === $this->id) {
            throw new \InvalidArgumentException('InterfaceShellNavItem id must be non-empty.');
        }
        $this->group = '' !== trim($this->group) ? trim($this->group) : 'tool';
        $this->url = trim($this->url);
        if ('' === $this->url) {
            throw new \InvalidArgumentException('InterfaceShellNavItem url must be non-empty.');
        }
        $this->order = max(-100000, min(100000, $this->order));
    }

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function group(): string
    {
        return $this->group;
    }

    public function icon(): ?string
    {
        return $this->icon;
    }

    public function order(): int
    {
        return $this->order;
    }

    private static function assertSafeUrl(string $url, string $owner): string
    {
        $url = trim($url);
        if ('' === $url) {
            throw new \InvalidArgumentException($owner.' url must be non-empty.');
        }
        if (1 === preg_match('/[\x00-\x1F\x7F]/', $url)) {
            throw new \InvalidArgumentException($owner.' url contains control characters.');
        }
        $scheme = parse_url($url, PHP_URL_SCHEME);
        if (null === $scheme || false === $scheme || '' === $scheme) {
            return $url;
        }
        if (!in_array(strtolower($scheme), ['http', 'https', 'mailto', 'tel'], true)) {
            throw new \InvalidArgumentException($owner.' url uses an unsupported scheme.');
        }
        return $url;
    }}
