<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\ServiceInterface\Interfacing\Widget\Form;

use App\Domain\Interfacing\Model\Form\FormSpec;
use App\Domain\Interfacing\Model\Form\FormSubmitResult;

/**
 *
 */

/**
 *
 */
interface FormHandlerInterface
{
    /**
     * @return string
     */
    public function id(): string;

    /**
     * @param array $context
     * @return \App\Domain\Interfacing\Model\Form\FormSpec
     */
    public function spec(array $context = []): FormSpec;

    /** @return array<string,mixed> */
    public function initialValue(array $context = []): array;

    /** @param array<string,mixed> $value */
    public function submit(array $value, array $context = []): FormSubmitResult;
}
