<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\ServiceInterface\Interfacing\Doctor;

/**
 *
 */

/**
 *
 */
interface InterfacingDoctorInterface
{
    /**
     * @return array{ok:bool, item:list<array{code:string, ok:bool, message:string}>}
     */
    public function check(): array;
}
