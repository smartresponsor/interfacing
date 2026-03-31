<?php

declare(strict_types=1);

/* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

namespace App\Service\Interfacing\Builder;

use App\Contract\View\LayoutBlockSpec;
use App\Contract\View\LayoutScreenSpec;
use App\ServiceInterface\Interfacing\Builder\LayoutScreenSpecBuilderInterface;

final class LayoutScreenSpecBuilder implements LayoutScreenSpecBuilderInterface
{
    /** @var list<array{type:string, id:string, title?:string}> */
    private array $block = [];

    private function __construct(
        private readonly string $id,
    ) {
    }

    public static function create(string $id): self
    {
        return new self($id);
    }

    public function block(string $type, string $id, ?string $title = null): self
    {
        $b = ['type' => $type, 'id' => $id];
        if (null !== $title) {
            $b['title'] = $title;
        }
        $this->block[] = $b;

        return $this;
    }

    public function form(string $id, ?string $title = null): self
    {
        return $this->block('form', $id, $title);
    }

    public function metric(string $id, ?string $title = null): self
    {
        return $this->block('metric', $id, $title);
    }

    public function wizard(string $id, ?string $title = null): self
    {
        return $this->block('wizard', $id, $title);
    }

    public function build(): LayoutScreenSpec
    {
        $block = [];
        foreach ($this->block as $item) {
            $props = [];
            if (isset($item['title'])) {
                $props['title'] = $item['title'];
            }
            $block[] = new LayoutBlockSpec($item['type'], $item['id'], $props);
        }

        return new LayoutScreenSpec(block: $block, id: $this->id, title: ucfirst(str_replace(['.', '-', '_'], ' ', $this->id)));
    }
}
