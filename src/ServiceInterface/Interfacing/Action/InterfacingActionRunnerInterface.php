<?php declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Action;

use SmartResponsor\Interfacing\DomainInterface\Interfacing\Action\ActionIdInterface;

interface InterfacingActionRunnerInterface
{
    /** @param array<string, mixed> $input */
    public function run(ActionIdInterface $id, array $input): InterfacingActionRunResultInterface;
}

