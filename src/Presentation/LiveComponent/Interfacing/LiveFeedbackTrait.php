<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Presentation\LiveComponent\Interfacing;

use App\Interfacing\Contract\Ui\UiErrorBag;
use App\Interfacing\Contract\Ui\UiMessageBag;

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
