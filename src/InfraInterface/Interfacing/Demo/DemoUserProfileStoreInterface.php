<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\InfraInterface\Interfacing\Demo;

use SmartResponsor\Interfacing\Domain\Interfacing\Error\DomainOperationFailed;

interface DemoUserProfileStoreInterface
{
    /** @return array{name: string, email: string} */
    public function load(): array;

    /**
     * @throws DomainOperationFailed
     */
    public function save(string $name, string $email): void;
}
