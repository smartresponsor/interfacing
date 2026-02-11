<?php
    declare(strict_types=1);

    /* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

    namespace App\ServiceInterface\Interfacing\Builder;

    use App\Domain\Interfacing\Spec\LayoutScreenSpec;

    /**
     *
     */

    /**
     *
     */
    interface LayoutScreenSpecBuilderInterface
{
    /**
     * @return \App\Domain\Interfacing\Spec\LayoutScreenSpec
     */
    public function build(): LayoutScreenSpec;
}

