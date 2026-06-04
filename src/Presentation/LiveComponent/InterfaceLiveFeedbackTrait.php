<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Presentation\LiveComponent;

use App\Interfacing\Contract\Ui\InterfaceUiErrorBag;
use App\Interfacing\Contract\Ui\InterfaceUiMessageBag;

trait InterfaceLiveFeedbackTrait
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

    public function applyUiErrorBag(InterfaceUiErrorBag $bag): void
    {
        $this->uiError = $bag->toArray();
    }

    public function applyUiMessageBag(InterfaceUiMessageBag $bag): void
    {
        $this->uiMessage = $bag->toArray();
    }
}
