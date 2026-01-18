<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Form;

interface FormSubmitResultInterface
{
    public function ok(): bool;

    public function message(): string;

    public function fieldError(): array;

    public function value(): array;
}
