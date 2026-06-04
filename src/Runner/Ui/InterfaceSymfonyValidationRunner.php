<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Runner\Ui;

use App\Interfacing\Contract\Ui\InterfaceUiErrorBag;
use App\Interfacing\MapperInterface\Ui\InterfaceUiErrorMapperInterface;
use App\Interfacing\RunnerInterface\Ui\InterfaceValidationRunnerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final readonly class InterfaceSymfonyValidationRunner implements InterfaceValidationRunnerInterface
{
    public function __construct(
        private ValidatorInterface $validator,
        private InterfaceUiErrorMapperInterface $errorMapper,
    ) {
    }

    public function validate(object $input, ?array $group = null): InterfaceUiErrorBag
    {
        $violations = $this->validator->validate($input, null, $group);

        return $this->errorMapper->fromViolationList($violations);
    }
}
