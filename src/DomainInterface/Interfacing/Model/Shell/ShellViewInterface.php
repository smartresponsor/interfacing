<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\DomainInterface\Interfacing\Model\Shell;

/**
 *
 */

/**
 *
 */
interface ShellViewInterface
{
    /**
     * @return string|null
     */
    public function activeId(): ?string;

    /**
     * @return string
     */
    public function query(): string;

    /**
     * @return array
     */
    public function group(): array;

    /**
     * @return int
     */
    public function itemTotal(): int;
}
