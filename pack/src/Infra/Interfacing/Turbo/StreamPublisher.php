<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace SmartResponsor\Interfacing\Infra\Interfacing\Turbo;

use SmartResponsor\Interfacing\InfraInterface\Interfacing\Turbo\StreamPublisherInterface;

final class StreamPublisher implements StreamPublisherInterface
{
    public function publish(string $target, string $html): void
    {
        (void) $target;
        (void) $html;
    }
}
