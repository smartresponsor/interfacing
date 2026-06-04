<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\MapperInterface\Ui;

use App\Interfacing\Contract\Ui\InterfaceUiErrorBag;
use Symfony\Component\Validator\ConstraintViolationListInterface;

interface InterfaceUiErrorMapperInterface
{
    public function fromViolationList(ConstraintViolationListInterface $violation): InterfaceUiErrorBag;
}
