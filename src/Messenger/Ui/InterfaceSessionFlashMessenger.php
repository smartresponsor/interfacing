<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\Messenger\Ui;

use App\Interfacing\Contract\Ui\InterfaceUiMessage;
use App\Interfacing\Contract\Ui\InterfaceUiMessageBag;
use App\Interfacing\MessengerInterface\Ui\InterfaceSessionFlashMessengerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\FlashBagAwareSessionInterface;

final class InterfaceSessionFlashMessenger implements InterfaceSessionFlashMessengerInterface
{
    private const FLASH_KEY = 'interfacing_message';

    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    public function push(InterfaceUiMessage $message): void
    {
        $request = $this->requestStack->getCurrentRequest();
        if (null === $request || !$request->hasSession()) {
            return;
        }

        $session = $request->getSession();
        if (!$session instanceof FlashBagAwareSessionInterface) {
            return;
        }

        $session->getFlashBag()->add(self::FLASH_KEY, $message->toArray());
    }

    public function pull(): InterfaceUiMessageBag
    {
        $request = $this->requestStack->getCurrentRequest();
        if (null === $request || !$request->hasSession()) {
            return new InterfaceUiMessageBag();
        }

        $session = $request->getSession();
        if (!$session instanceof FlashBagAwareSessionInterface) {
            return new InterfaceUiMessageBag();
        }

        $bag = new InterfaceUiMessageBag();
        $items = $session->getFlashBag()->get(self::FLASH_KEY);

        foreach ($items as $row) {
            if (is_array($row)) {
                $bag->add(InterfaceUiMessage::fromArray($row));
            }
        }

        return $bag;
    }
}
