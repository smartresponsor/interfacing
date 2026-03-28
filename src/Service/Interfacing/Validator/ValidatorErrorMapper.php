<?php

declare(strict_types=1);

namespace App\Service\Interfacing\Validator;

use App\Contract\Ui\UiError;
use App\Contract\Ui\UiErrorBag;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class ValidatorErrorMapper
{
    public function map(ConstraintViolationListInterface $violations): UiErrorBag
    {
        $bag = new UiErrorBag();
        foreach ($violations as $violation) {
            $field = trim((string) $violation->getPropertyPath());
            $error = new UiError('validation', '' !== $field ? $field : null, (string) $violation->getMessage(), 'validation');
            if ('' === $field) {
                $bag->addGlobal($error);
            } else {
                $bag->addField($field, $error);
            }
        }

        return $bag;
    }
}
