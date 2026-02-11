<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Service\Interfacing\Validator;

use App\Domain\Interfacing\Model\UiError;
use App\Domain\Interfacing\Model\UiErrorBag;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class ValidatorErrorMapper
{
    public function map(ConstraintViolationListInterface $list): UiErrorBag
    {
        $bag = new UiErrorBag();
        foreach ($list as $v) {
            $bag->add(new UiError((string)$v->getPropertyPath(), (string)$v->getMessage()));
        }
        return $bag;
    }
}
