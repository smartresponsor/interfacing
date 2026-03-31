<?php

declare(strict_types=1);

namespace App\Contract\ValueObject;

interface LayoutIdInterface
{
    public function value(): string;

    public function toString(): string;
}
