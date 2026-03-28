<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\ServiceInterface\Interfacing\Widget\Form;

use App\Contract\Dto\FormSubmitResult;
use App\Contract\View\FormSpec;

interface FormHandlerInterface
{
    public function id(): string;

    public function spec(array $context = []): FormSpec;

    /** @return array<string,mixed> */
    public function initialValue(array $context = []): array;

    /** @param array<string,mixed> $value */
    public function submit(array $value, array $context = []): FormSubmitResult;
}
