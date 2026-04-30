<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\View;

use App\Interfacing\Contract\ValueObject\ScreenId;
use App\Interfacing\Contract\ValueObject\ScreenIdInterface;

final class LayoutScreenSpec implements LayoutScreenSpecInterface
{
    /** @var array<int, LayoutBlockSpecInterface> */
    private array $block;

    /**
     * @param array<int, LayoutBlockSpecInterface> $block
     */
    public function __construct(
        array $block = [],
        private string $id = 'layout',
        private string $title = 'Layout',
        private string $description = '',
        private string $navGroup = 'tool',
        private ?ScreenIdInterface $screenId = null,
        private ?string $guardKey = null,
        private ?string $routePath = null,
        private array $context = [],
        private int $navOrder = 0,
    ) {
        $this->block = $block;
        $this->screenId ??= ScreenId::of($this->id);
    }

    public function block(): array
    {
        return $this->block;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function slug(): string
    {
        return $this->id();
    }

    public function title(): string
    {
        return $this->title;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function navGroup(): string
    {
        return $this->navGroup;
    }

    public function screenId(): ScreenIdInterface
    {
        return $this->screenId;
    }

    public function guardKey(): ?string
    {
        return $this->guardKey;
    }

    public function routePath(): ?string
    {
        return $this->routePath;
    }

    public function navOrder(): int
    {
        return $this->navOrder;
    }

    public function context(): array
    {
        return $this->context;
    }
}
