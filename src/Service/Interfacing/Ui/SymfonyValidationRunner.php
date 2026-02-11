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

/**
 *
 */

/**
 *
 */
final readonly class SymfonyValidationRunner implements ValidationRunnerInterface
{
    /**
     * @param \Symfony\Component\Validator\Validator\ValidatorInterface $validator
     * @param \App\ServiceInterface\Interfacing\Ui\UiErrorMapperInterface $errorMapper
     */
    public function __construct(
        private ValidatorInterface     $validator,
        private UiErrorMapperInterface $errorMapper,
    ) {
    }

    /**
     * @param object $input
     * @param array|null $group
     * @return \App\Domain\Interfacing\Ui\UiErrorBag
     */
    public function validate(object $input, ?array $group = null): UiErrorBag
    {
        $violations = $this->validator->validate($input, null, $group);
        return $this->errorMapper->fromViolationList($violations);
    }
}
