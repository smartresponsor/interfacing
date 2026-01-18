<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\BulkAction;

interface BulkActionSpecInterface
{
    public function id(): string;

    public function title(): string;

    public function confirm(): bool;
}
