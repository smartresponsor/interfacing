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
interface WizardSpecInterface
{
    /**
     * @return string
     */
    public function id(): string;

    /**
     * @return string
     */
    public function title(): string;

    /**
     * @return array
     */
    public function step(): array;

    /**
     * @return string
     */
    public function finishLabel(): string;

    /**
     * @return string
     */
    public function cancelLabel(): string;
}
