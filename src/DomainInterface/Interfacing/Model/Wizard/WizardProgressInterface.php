<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\DomainInterface\Interfacing\Model\Wizard;

/**
 *
 */

/**
 *
 */
interface WizardProgressInterface
{
    /**
     * @return int
     */
    public function index(): int;

    /**
     * @return int
     */
    public function total(): int;

    /**
     * @return float
     */
    public function percent(): float;

    /**
     * @return bool
     */
    public function isFirst(): bool;

    /**
     * @return bool
     */
    public function isLast(): bool;
}
