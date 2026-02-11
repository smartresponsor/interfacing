<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\DomainInterface\Interfacing\Model;

/**
 *
 */

/**
 *
 */
interface UiStateInterface
{
    /**
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public function with(string $key, mixed $value): self;

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed;

    /**
     * @return array
     */
    public function toArray(): array;
}
