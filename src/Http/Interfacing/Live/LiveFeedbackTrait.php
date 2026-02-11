<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Http\Interfacing\Live;

use App\Domain\Interfacing\Ui\UiErrorBag;
use App\Domain\Interfacing\Ui\UiMessageBag;

/**
 *
 */

/**
 *
 */
trait LiveFeedbackTrait
{
    /** @var array<string, mixed> */
    public array $uiError = ['global' => [], 'field' => []];

    /** @var array<int, array<string, mixed>> */
    public array $uiMessage = [];

    /**
     * @return void
     */
    public function clearUiFeedback(): void
    {
        $this->uiError = ['global' => [], 'field' => []];
        $this->uiMessage = [];
    }

    /**
     * @param \App\Domain\Interfacing\Ui\UiErrorBag $bag
     * @return void
     */
    public function applyUiErrorBag(UiErrorBag $bag): void
    {
        $this->uiError = $bag->toArray();
    }

    /**
     * @param \App\Domain\Interfacing\Ui\UiMessageBag $bag
     * @return void
     */
    public function applyUiMessageBag(UiMessageBag $bag): void
    {
        $this->uiMessage = $bag->toArray();
    }
}
