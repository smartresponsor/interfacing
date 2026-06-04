<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\HandlerInterface\Widget\Form;

use App\Interfacing\Contract\Dto\InterfaceFormSubmitResult;
use App\Interfacing\Contract\View\InterfaceFormSpec;

interface InterfaceFormHandlerInterface
{
    public function id(): string;

    public function spec(array $context = []): InterfaceFormSpec;

    /** @return array<string,mixed> */
    public function initialValue(array $context = []): array;

    /** @param array<string,mixed> $value */
    public function submit(array $value, array $context = []): InterfaceFormSubmitResult;
}
