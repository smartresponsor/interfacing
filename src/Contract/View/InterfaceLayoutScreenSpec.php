<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\View;

use App\Interfacing\Contract\ValueObject\InterfaceScreenId;
use App\Interfacing\Contract\ValueObject\InterfaceScreenIdInterface;

final class InterfaceLayoutScreenSpec implements InterfaceLayoutScreenSpecInterface
{
    /** @var array<int, InterfaceLayoutBlockSpecInterface> */
    private array $block;

    /**
     * @param array<int, InterfaceLayoutBlockSpecInterface> $block
     */
    public function __construct(
        array $block = [],
        private string $id = 'layout',
        private string $title = 'Layout',
        private string $description = '',
        private string $navGroup = 'tool',
        private ?InterfaceScreenIdInterface $screenId = null,
        private ?string $guardKey = null,
        private ?string $routePath = null,
        private array $context = [],
        private int $navOrder = 0,
    ) {
        $this->block = $block;
        $this->screenId ??= InterfaceScreenId::of($this->id);
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

    public function screenId(): InterfaceScreenIdInterface
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
