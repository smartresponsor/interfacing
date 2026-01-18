<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace SmartResponsor\Interfacing\Domain\Interfacing\Model\Screen;

use SmartResponsor\Interfacing\Domain\Interfacing\Model\ScreenId;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Screen\ScreenSpecInterface;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\ScreenIdInterface;

final class ScreenSpec implements ScreenSpecInterface
{
    private ScreenId $id;
    private string $title;
    private string $template;

    private function __construct(ScreenId $id, string $title, string $template)
    {
        $title = trim($title);
        $template = trim($template);

        if ($title === '') {
            throw new \InvalidArgumentException('ScreenSpec title must not be empty.');
        }
        if ($template === '') {
            throw new \InvalidArgumentException('ScreenSpec template must not be empty.');
        }

        $this->id = $id;
        $this->title = $title;
        $this->template = $template;
    }

    public static function create(ScreenId $id, string $title, string $template): self
    {
        return new self($id, $title, $template);
    }

    public function getId(): ScreenIdInterface
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }
}
