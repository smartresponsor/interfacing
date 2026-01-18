<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace App\Domain\Interfacing\Model\Layout;

use App\Domain\Interfacing\Model\ScreenId;
use App\DomainInterface\Interfacing\Model\Layout\LayoutScreenSpecInterface;
use App\DomainInterface\Interfacing\Model\ScreenIdInterface;

final class LayoutScreenSpec implements LayoutScreenSpecInterface
{
    private string $slug;
    private string $title;
    private string $navGroup;
    private ScreenId $screenId;
    private ?string $guardKey;
    /** @var array<string,mixed> */
    private array $context;

    /**
     * @param array<string,mixed> $context
     */
    private function __construct(string $slug, string $title, string $navGroup, ScreenId $screenId, ?string $guardKey, array $context)
    {
        $slug = trim($slug);
        $title = trim($title);
        $navGroup = trim($navGroup);

        if ($slug === '' || !preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $slug)) {
            throw new \InvalidArgumentException('LayoutScreenSpec slug must match slug format: lowercase words separated by single hyphen.');
        }
        if ($title === '') {
            throw new \InvalidArgumentException('LayoutScreenSpec title must not be empty.');
        }
        if ($navGroup === '' || !preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $navGroup)) {
            throw new \InvalidArgumentException('LayoutScreenSpec navGroup must match slug format: lowercase words separated by single hyphen.');
        }

        $this->slug = $slug;
        $this->title = $title;
        $this->navGroup = $navGroup;
        $this->screenId = $screenId;
        $this->guardKey = $guardKey !== null ? trim($guardKey) : null;
        $this->context = $context;
    }

    /**
     * @param array<string,mixed> $context
     */
    public static function create(string $slug, string $title, string $navGroup, ScreenId $screenId, ?string $guardKey = null, array $context = []): self
    {
        return new self($slug, $title, $navGroup, $screenId, $guardKey, $context);
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getNavGroup(): string
    {
        return $this->navGroup;
    }

    public function getScreenId(): ScreenIdInterface
    {
        return $this->screenId;
    }

    public function getGuardKey(): ?string
    {
        return $this->guardKey;
    }

    /**
     * @return array<string,mixed>
     */
    public function getContext(): array
    {
        return $this->context;
    }
}
