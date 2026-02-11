<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\DomainInterface\Interfacing\Model\Metric;

interface MetricCardInterface
{
    public function id(): string;

    public function title(): string;

    public function current(): float;

    public function previous(): float;

    public function delta(): float;

    public function deltaPercent(): float;

    public function format(): string;

    public function unit(): string;

    public function isUp(): bool;

    public function isDown(): bool;
}
