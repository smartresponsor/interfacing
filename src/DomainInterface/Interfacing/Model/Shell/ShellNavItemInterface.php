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
interface ShellNavItemInterface
{
    /**
     * @return string
     */
    public function id(): string;

    /**
     * @return string
     */
    public function title(): string;

    /**
     * @return string
     */
    public function url(): string;

    /**
     * @return string
     */
    public function group(): string;

    /**
     * @return string|null
     */
    public function icon(): ?string;

    /**
     * @return int
     */
    public function order(): int;
}
