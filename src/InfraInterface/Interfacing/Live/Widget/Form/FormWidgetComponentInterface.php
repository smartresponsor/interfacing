<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\InfraInterface\Interfacing\Live\Widget\Form;

use App\Domain\Interfacing\Model\Form\FormSpec;

interface FormWidgetComponentInterface
{
    public function spec(): FormSpec;

    public function fieldValue(string $id): mixed;

    public function fieldErrorFor(string $id): string;
}
