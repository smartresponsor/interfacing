<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace App\InfraInterface\Interfacing\Turbo;

interface StreamPublisherInterface
{
    public function publish(string $target, string $html): void;
}
