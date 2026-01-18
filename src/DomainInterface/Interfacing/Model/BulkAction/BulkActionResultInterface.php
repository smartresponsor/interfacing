<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\BulkAction;

interface BulkActionResultInterface
{
    public function message(): string;

    public function removedId(): array;

    public function updatedId(): array;
}
