<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Surface;

final readonly class InterfaceProductSurfaceContract implements InterfaceSurfaceRenderableInterface
{
    public const WORD = 'product';
    public const VIEW_INDEX = 'index';

    /**
     * @param array<string, string> $slotMap
     * @param array<string, mixed>  $slots
     */
    public function __construct(
        public string $word,
        public string $view,
        public string $templateName,
        public array $slotMap,
        public array $showcase,
        public array $slots,
    ) {
    }

    /**
     * @return array{word: string, view: string, templateName: string, slotMap: array<string, string>, showcase: array<string, mixed>, slots: array<string, mixed>}
     */
    public function toTemplateContext(): array
    {
        return [
            'word' => $this->word,
            'view' => $this->view,
            'templateName' => $this->templateName,
            'slotMap' => $this->slotMap,
            'showcase' => $this->showcase,
            'slots' => $this->slots,
        ];
    }

    /**
     * @return array{word: string, view: string, showcase: array<string, mixed>, slots: array<string, mixed>}
     */
    public function toFallbackData(): array
    {
        return [
            'word' => $this->word,
            'view' => $this->view,
            'showcase' => $this->showcase,
            'slots' => $this->slots,
        ];
    }

    public function templateName(): string
    {
        return $this->templateName;
    }
}
