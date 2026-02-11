<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Domain\Interfacing\Model\Metric;

/**
 *
 */

/**
 *
 */
final class MetricSpec
{
    /**
     * @param string $id
     * @param string $title
     * @param string $format
     * @param string $unit
     */
    public function __construct(
        private string          $id,
        private readonly string $title,
        private string          $format = 'int',
        private string          $unit = '',
    ) {
        $this->id = trim($this->id);
        if ($this->id === '') {
            throw new \InvalidArgumentException('MetricSpec id must be non-empty.');
        }
        $this->format = trim($this->format) !== '' ? trim($this->format) : 'int';
        $this->unit = trim($this->unit);
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function format(): string
    {
        return $this->format;
    }

    /**
     * @return string
     */
    public function unit(): string
    {
        return $this->unit;
    }
}
