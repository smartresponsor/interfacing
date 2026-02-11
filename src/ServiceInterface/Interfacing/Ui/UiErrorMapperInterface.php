<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\ServiceInterface\Interfacing\Ui;

use App\Domain\Interfacing\Ui\UiErrorBag;
use Symfony\Component\Validator\ConstraintViolationListInterface;

interface UiErrorMapperInterface
{
    public function fromViolationList(ConstraintViolationListInterface $violation): UiErrorBag;
}
