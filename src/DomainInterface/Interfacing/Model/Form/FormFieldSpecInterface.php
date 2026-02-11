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
interface FormFieldSpecInterface
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
    public function type(): string;

    /**
     * @return bool
     */
    public function required(): bool;

    /**
     * @return string
     */
    public function placeholder(): string;

    /**
     * @return array
     */
    public function option(): array;
}
