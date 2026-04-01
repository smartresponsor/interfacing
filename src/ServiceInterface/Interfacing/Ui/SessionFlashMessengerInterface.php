<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\ServiceInterface\Interfacing\Ui;

use App\Contract\Ui\UiMessage;
use App\Contract\Ui\UiMessageBag;

interface SessionFlashMessengerInterface
{
    public function push(UiMessage $message): void;

    /**
     * Pulls and clears all Interfacing messages from the session flash bag.
     * When the session is not available, returns an empty bag.
     */
    public function pull(): UiMessageBag;
}
