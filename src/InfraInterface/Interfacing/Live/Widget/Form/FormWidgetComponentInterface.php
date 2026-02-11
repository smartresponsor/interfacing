<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\InfraInterface\Interfacing\Live\Widget\Form;

use App\Domain\Interfacing\Model\Form\FormSpec;

/**
 *
 */

/**
 *
 */
interface FormWidgetComponentInterface
{
    /**
     * @return \App\Domain\Interfacing\Model\Form\FormSpec
     */
    public function spec(): FormSpec;

    /**
     * @param string $id
     * @return mixed
     */
    public function fieldValue(string $id): mixed;

    /**
     * @param string $id
     * @return string
     */
    public function fieldErrorFor(string $id): string;
}
