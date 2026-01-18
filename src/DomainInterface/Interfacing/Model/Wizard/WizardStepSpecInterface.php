<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\DomainInterface\Interfacing\Model\Wizard;

interface WizardStepSpecInterface
{
    public function id(): string;

    public function title(): string;

    public function hint(): string;

    public function field(): array;
}
