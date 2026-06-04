<?php

declare(strict_types=1);

namespace App\Interfacing\Presentation\Controller;

use App\Interfacing\ProviderInterface\Messaging\InterfaceMessagingShowcaseProviderInterface;
use App\Interfacing\ServiceInterface\Rendering\InterfaceRendererInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final readonly class InterfaceMessagingShowcaseController
{
    public function __construct(
        private InterfaceRendererInterface $renderer,
        private InterfaceMessagingShowcaseProviderInterface $messagingShowcaseProvider,
    ) {
    }

    #[Route('/interfacing/showcase/message', name: 'interfacing_messaging_showcase', methods: ['GET'], priority: 1350)]
    #[Route('/interfacing/showcase/message/alias', name: 'interfacing_messaging_showcase_no_slash', methods: ['GET'], priority: 1350)]
    public function index(Request $request): Response
    {
        return $this->renderShowcase($request, 'overview');
    }

    #[Route('/interfacing/showcase/message/{section}', name: 'interfacing_messaging_showcase_section', requirements: ['section' => 'inbox|outbox|compose|rooms|chats|search|digest'], methods: ['GET'], priority: 1350)]
    public function section(Request $request, string $section): Response
    {
        return $this->renderShowcase($request, $section);
    }

    private function renderShowcase(Request $request, string $section): Response
    {
        $criteria = $request->query->all();
        $criteria['section'] = $section;

        return $this->renderer->render('@Interfacing/message/messaging_showcase.html.twig', [
            'screenId' => 'messaging.showcase',
            'title' => 'Messaging · Smart Responsor',
            'messagingShowcase' => $this->messagingShowcaseProvider->provide($criteria),
        ]);
    }
}
