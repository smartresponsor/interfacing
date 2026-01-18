<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Widget\Form;

use SmartResponsor\Interfacing\Domain\Interfacing\Model\Form\FormSpec;
use SmartResponsor\Interfacing\Domain\Interfacing\Model\Form\FormSubmitResult;

interface FormHandlerInterface
{
    public function id(): string;

    public function spec(array $context = []): FormSpec;

    /** @return array<string,mixed> */
    public function initialValue(array $context = []): array;

    /** @param array<string,mixed> $value */
    public function submit(array $value, array $context = []): FormSubmitResult;
}
