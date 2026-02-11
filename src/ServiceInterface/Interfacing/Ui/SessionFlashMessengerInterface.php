<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\ServiceInterface\Interfacing\Ui;

use App\Domain\Interfacing\Ui\UiMessage;
use App\Domain\Interfacing\Ui\UiMessageBag;

/**
 *
 */

/**
 *
 */
interface SessionFlashMessengerInterface
{
    /**
     * @param \App\Domain\Interfacing\Ui\UiMessage $message
     * @return void
     */
    public function push(UiMessage $message): void;

    /**
     * Pulls and clears all Interfacing messages from the session flash bag.
     * When the session is not available, returns an empty bag.
     */
    public function pull(): UiMessageBag;
}
