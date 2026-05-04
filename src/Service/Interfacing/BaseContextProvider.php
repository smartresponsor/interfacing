<?php

declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\Service\Interfacing;

use App\Interfacing\ServiceInterface\Interfacing\Context\BaseContextProviderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class BaseContextProvider implements BaseContextProviderInterface
{
    public function __construct(private readonly RequestStack $requestStack, private readonly ?TokenStorageInterface $tokenStorage = null)
    {
    }

    /**
     * @return array|mixed[]
     */
    public function provide(): array
    {
        $req = $this->requestStack->getCurrentRequest();
        $token = $this->tokenStorage->getToken();

        return [
            'requestId' => $req?->headers->get('X-Request-Id') ?? null,
            'path' => $req?->getPathInfo() ?? null,
            'user' => $token?->getUserIdentifier() ?? null,
        ];
    }
}
