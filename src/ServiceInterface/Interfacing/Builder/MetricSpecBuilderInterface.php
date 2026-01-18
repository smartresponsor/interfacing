<?php
    declare(strict_types=1);

    /* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

    namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Builder;

    use SmartResponsor\Interfacing\Domain\Interfacing\Spec\MetricSpec;

interface MetricSpecBuilderInterface
{
    public function build(): MetricSpec;
}

