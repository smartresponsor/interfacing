Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
<?php
declare(strict_types=1);

namespace App\Infra\Interfacing\Http;

use App\DomainInterface\Interfacing\Context\BaseContextProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class InterfacingWhoAmIController extends AbstractController
{
    public function __construct(
        private readonly TokenStorageInterface $tokenStorage,
        private readonly BaseContextProviderInterface $baseContext,
    ) {}

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
