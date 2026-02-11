<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Domain\Interfacing\Model;

use App\Domain\Interfacing\Value\ScreenId;

/**
 *
 */

/**
 *
 */
final class ScreenSpec
{
    private ScreenId $id;
    private string $title;
    private string $description;
    private string $viewId;
    private AccessRule $accessRule;

    /**
     * @param \App\Domain\Interfacing\Value\ScreenId $id
     * @param string $title
     * @param string $description
     * @param string $viewId
     * @param \App\Domain\Interfacing\Model\AccessRule $accessRule
     */
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

    /**
     * @return \App\Domain\Interfacing\Value\ScreenId
     */
    public function id(): ScreenId { return $this->id; }

    /**
     * @return string
     */
    public function title(): string { return $this->title; }

    /**
     * @return string
     */
    public function description(): string { return $this->description; }

    /**
     * @return string
     */
    public function viewId(): string { return $this->viewId; }

    /**
     * @return \App\Domain\Interfacing\Model\AccessRule
     */
    public function accessRule(): AccessRule { return $this->accessRule; }
}
