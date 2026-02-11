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
interface WizardStepSpecInterface
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
     * @return string
     */
    public function hint(): string;

    /**
     * @return array
     */
    public function field(): array;
}
