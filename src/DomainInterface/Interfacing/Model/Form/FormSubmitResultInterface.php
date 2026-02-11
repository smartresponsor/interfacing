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
interface FormSubmitResultInterface
{
    /**
     * @return bool
     */
    public function ok(): bool;

    /**
     * @return string
     */
    public function message(): string;

    /**
     * @return array
     */
    public function fieldError(): array;

    /**
     * @return array
     */
    public function value(): array;
}
