<?php

declare(strict_types=1);

namespace App\Contract\ValueObject;

interface ActionIdInterface
{
    public function value(): string;

    public function toString(): string;
}
