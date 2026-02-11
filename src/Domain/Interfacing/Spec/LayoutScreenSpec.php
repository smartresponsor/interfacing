<?php
    declare(strict_types=1);

    /* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

    namespace App\Domain\Interfacing\Spec;

    /**
     *
     */

    /**
     *
     */
    final readonly class LayoutScreenSpec
{
    /** @var list<array{type:string, id:string, title?:string}> */
    public array $block;

    /**
     * @param list<array{type:string, id:string, title?:string}> $block
     */
    public function __construct(
        public string $id,
        array         $block,
    ) {
        $this->block = $block;
    }
}

