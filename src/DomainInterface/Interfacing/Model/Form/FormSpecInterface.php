<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\DomainInterface\Interfacing\Model\Form;

/**
 *
 */

/**
 *
 */
interface FormSpecInterface
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
    public function field(): array;

    /**
     * @return string
     */
    public function submitLabel(): string;

    /**
     * @return string
     */
    public function hint(): string;
}
