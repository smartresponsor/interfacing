<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Contract\View;

interface MetricSpecInterface
{
    public function id(): string;

    public function title(): string;

    public function format(): string;

    public function unit(): string;
}
