<?php

declare(strict_types=1);

namespace App\Interfacing\EventSubscriber;

use Symfony\Component\DependencyInjection\Attribute\When;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

#[When(env: 'dev')]
final readonly class InterfaceRedirectLocalHttpsToHttpSubscriber implements EventSubscriberInterface
{
    /**
     * @return array<string, string|array{0:string,1?:int}>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 40],
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();
        if ('https' !== $request->getScheme()) {
            return;
        }

        if (!in_array($request->getHost(), ['127.0.0.1', 'localhost'], true)) {
            return;
        }

        $targetUrl = 'http://'.$request->getHttpHost().$request->getRequestUri();
        $event->setResponse(new RedirectResponse($targetUrl, 302));
    }
}
