<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\ValueObject;

interface ScreenIdInterface
{
    public function value(): string;

    public function toString(): string;
}
