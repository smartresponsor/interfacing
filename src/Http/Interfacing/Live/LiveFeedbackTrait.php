<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\Http\Interfacing\Live;

use SmartResponsor\Interfacing\Domain\Interfacing\Ui\UiErrorBag;
use SmartResponsor\Interfacing\Domain\Interfacing\Ui\UiMessageBag;

trait LiveFeedbackTrait
{
    /** @var array<string, mixed> */
    public array $uiError = ['global' => [], 'field' => []];

    /** @var array<int, array<string, mixed>> */
    public array $uiMessage = [];

    public function clearUiFeedback(): void
    {
        $this->uiError = ['global' => [], 'field' => []];
        $this->uiMessage = [];
    }

    public function applyUiErrorBag(UiErrorBag $bag): void
    {
        $this->uiError = $bag->toArray();
    }

    public function applyUiMessageBag(UiMessageBag $bag): void
    {
        $this->uiMessage = $bag->toArray();
    }
}
