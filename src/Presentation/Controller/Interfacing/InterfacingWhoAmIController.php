<?php

declare(strict_types=1);

namespace App\Presentation\Controller\Interfacing;

use App\ServiceInterface\Interfacing\Context\RequestBaseContextProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final readonly class InterfacingWhoAmIController extends AbstractController
{
    /**
     * @param \App\ServiceInterface\Interfacing\Context\RequestRequestBaseContextProviderInterface $baseContext
     */
    public function __construct(
        private TokenStorageInterface $tokenStorage,
        private RequestBaseContextProviderInterface $baseContext,
    ) {
    }

    #[Route(path: '/interfacing/whoami', name: 'interfacing_whoami', methods: ['GET'])]
    public function whoami(Request $request): JsonResponse
    {
        $token = $this->tokenStorage->getToken();
        $ctx = $this->baseContext->provide($request, $token);

        return new JsonResponse([
            'tenantId' => $ctx['tenantId'] ?? null,
            'userId' => $ctx['userId'] ?? null,
            'requestId' => $ctx['requestId'] ?? null,
            'path' => $ctx['path'] ?? null,
        ]);
    }
}
