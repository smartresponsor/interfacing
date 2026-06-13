<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\StoreInterface\Demo;

use App\Interfacing\Contract\Error\InterfaceDomainOperationFailed;

interface InterfaceDemoUserProfileStoreInterface
{
    /** @return array{name: string, email: string} */
    public function load(): array;

    /**
     * @throws InterfaceDomainOperationFailed
     */
    public function save(string $nameEntity, string $email): void;
}
