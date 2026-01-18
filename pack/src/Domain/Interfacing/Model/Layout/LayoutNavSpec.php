<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace App\Domain\Interfacing\Model\Layout;

use App\DomainInterface\Interfacing\Model\Layout\LayoutNavSpecInterface;

final class LayoutNavSpec implements LayoutNavSpecInterface
{
    /** @var array<string, list<array{slug:string,title:string,active:bool}>> */
    private array $groupItem;
    private string $activeSlug;

    /**
     * @param array<string, list<array{slug:string,title:string,active:bool}>> $groupItem
     */
    private function __construct(array $groupItem, string $activeSlug)
    {
        $this->groupItem = $groupItem;
        $this->activeSlug = $activeSlug;
    }

    /**
     * @param array<string, list<array{slug:string,title:string,active:bool}>> $groupItem
     */
    public static function create(array $groupItem, string $activeSlug): self
    {
        return new self($groupItem, $activeSlug);
    }

    /**
     * @return array<string, list<array{slug:string,title:string,active:bool}>>
     */
    public function getGroupItem(): array
    {
        return $this->groupItem;
    }

    public function getActiveSlug(): string
    {
        return $this->activeSlug;
    }
}
