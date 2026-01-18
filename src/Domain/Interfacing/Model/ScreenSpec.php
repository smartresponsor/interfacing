<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace SmartResponsor\Interfacing\Domain\Interfacing\Model;

use SmartResponsor\Interfacing\Domain\Interfacing\Value\ScreenId;

final class ScreenSpec
{
    private ScreenId $id;
    private string $title;
    private string $description;
    private string $viewId;
    private AccessRule $accessRule;

    public function __construct(ScreenId $id, string $title, string $description, string $viewId, AccessRule $accessRule)
    {
        if ($title === '' || $viewId === '') {
            throw new \InvalidArgumentException('ScreenSpec requires title and viewId.');
        }
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->viewId = $viewId;
        $this->accessRule = $accessRule;
    }

    public function id(): ScreenId { return $this->id; }
    public function title(): string { return $this->title; }
    public function description(): string { return $this->description; }
    public function viewId(): string { return $this->viewId; }
    public function accessRule(): AccessRule { return $this->accessRule; }
}
