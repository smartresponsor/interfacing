<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\InfraInterface\Interfacing\Live\Widget\Form;

use SmartResponsor\Interfacing\Domain\Interfacing\Model\Form\FormSpec;

interface FormWidgetComponentInterface
{
    public function spec(): FormSpec;

    public function fieldValue(string $id): mixed;

    public function fieldErrorFor(string $id): string;
}
