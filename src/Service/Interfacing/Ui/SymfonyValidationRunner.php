<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Service\Interfacing\Ui;

use App\Domain\Interfacing\Ui\UiErrorBag;
use App\ServiceInterface\Interfacing\Ui\UiErrorMapperInterface;
use App\ServiceInterface\Interfacing\Ui\ValidationRunnerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class SymfonyValidationRunner implements ValidationRunnerInterface
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly UiErrorMapperInterface $errorMapper,
    ) {
    }

    public function validate(object $input, ?array $group = null): UiErrorBag
    {
        $violations = $this->validator->validate($input, null, $group);
        return $this->errorMapper->fromViolationList($violations);
    }
}
