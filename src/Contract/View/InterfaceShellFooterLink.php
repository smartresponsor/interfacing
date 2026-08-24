<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\View;

final class InterfaceShellFooterLink implements InterfaceShellFooterLinkInterface
{
    public function __construct(
        private readonly string $title,
        private readonly string $url,
    ) {
    }

    public function title(): string
    {
        return $this->title;
    }

    public function url(): string
    {
        return $this->url;
    }

    private static function assertSafeUrl(string $url): void
    {
        $url = trim($url);
        if ('' === $url || 1 === preg_match('/[\x00-\x1F\x7F]/', $url)) {
            throw new \InvalidArgumentException('InterfaceShellFooterLink url must be a non-empty safe URL.');
        }
        $scheme = parse_url($url, PHP_URL_SCHEME);
        if (null !== $scheme && false !== $scheme && '' !== $scheme && !in_array(strtolower($scheme), ['http', 'https', 'mailto', 'tel'], true)) {
            throw new \InvalidArgumentException('InterfaceShellFooterLink url uses an unsupported scheme.');
        }
    }}
