<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\Domain\Interfacing\Model\Metric;

final class MetricSpec
{
    public function __construct(
        private string $id,
        private string $title,
        private string $format = 'int',
        private string $unit = '',
    ) {
        $this->id = trim($this->id);
        if ($this->id === '') {
            throw new \InvalidArgumentException('MetricSpec id must be non-empty.');
        }
        $this->format = trim($this->format) !== '' ? trim($this->format) : 'int';
        $this->unit = trim($this->unit);
    }

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function format(): string
    {
        return $this->format;
    }

    public function unit(): string
    {
        return $this->unit;
    }
}
