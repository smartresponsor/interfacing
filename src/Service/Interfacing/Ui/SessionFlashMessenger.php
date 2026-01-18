<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Service\Interfacing\Ui;

use App\Domain\Interfacing\Ui\UiMessage;
use App\Domain\Interfacing\Ui\UiMessageBag;
use App\ServiceInterface\Interfacing\Ui\SessionFlashMessengerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final class SessionFlashMessenger implements SessionFlashMessengerInterface
{
    private const FLASH_KEY = 'interfacing_message';

    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    public function push(UiMessage $message): void
    {
        $request = $this->requestStack->getCurrentRequest();
        if ($request === null) {
            return;
        }

        $session = $request->getSession();
        if ($session === null) {
            return;
        }

        $session->getFlashBag()->add(self::FLASH_KEY, $message->toArray());
    }

    public function pull(): UiMessageBag
    {
        $request = $this->requestStack->getCurrentRequest();
        if ($request === null) {
            return new UiMessageBag();
        }

        $session = $request->getSession();
        if ($session === null) {
            return new UiMessageBag();
        }

        $bag = new UiMessageBag();
        $items = $session->getFlashBag()->get(self::FLASH_KEY, []);
        foreach ($items as $row) {
            if (is_array($row)) {
                $bag->add(UiMessage::fromArray($row));
            }
        }

        return $bag;
    }
}
