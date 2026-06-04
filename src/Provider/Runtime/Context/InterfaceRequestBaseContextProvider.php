<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Provider\Runtime\Context;

use App\Interfacing\ProviderInterface\Runtime\InterfaceBaseContextProviderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class InterfaceRequestBaseContextProvider implements InterfaceBaseContextProviderInterface
{
    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly ?TokenStorageInterface $tokenStorage = null,
    ) {
    }

    /**
     * @return array|mixed[]
     */
    public function context(): array
    {
        $req = $this->requestStack->getCurrentRequest();

        $ctx = [
            'now' => (new \DateTimeImmutable('now'))->format(\DateTimeInterface::ATOM),
        ];

        if (null !== $req) {
            $ctx['locale'] = $req->getLocale();
            $ctx['path'] = $req->getPathInfo();
            $ctx['method'] = $req->getMethod();
            $ctx['query'] = $req->query->all();
            $ctx['ip'] = $req->getClientIp();
            $ua = $req->headers->get('User-Agent');
            if (is_string($ua) && '' !== trim($ua)) {
                $ctx['userAgent'] = $ua;
            }
        }

        if (null !== $this->tokenStorage) {
            $token = $this->tokenStorage->getToken();
            if (null !== $token) {
                $user = $token->getUser();
                $ctx['user'] = $this->normalizeUser($user);
            }
        }

        return $ctx;
    }

    /**
     * @return array|null[]|string[]
     */
    /**
     * @return array|null[]|string[]
     */
    private function normalizeUser($user): array
    {
        if (null === $user) {
            return ['id' => null];
        }

        if (is_string($user)) {
            return ['id' => $user, 'label' => $user];
        }

        if (is_object($user)) {
            $id = null;
            $label = null;

            if (method_exists($user, 'getUserIdentifier')) {
                $id = (string) $user->getUserIdentifier();
            } elseif (method_exists($user, 'getUsername')) {
                $id = (string) $user->getUsername();
            } elseif (method_exists($user, '__toString')) {
                $id = (string) $user;
            }

            if (method_exists($user, 'getEmail')) {
                $label = (string) $user->getEmail();
            } elseif (method_exists($user, 'getName')) {
                $label = (string) $user->getName();
            } elseif (null !== $id) {
                $label = $id;
            }

            return [
                'id' => $id,
                'label' => $label,
                'class' => $user::class,
            ];
        }

        return ['id' => null];
    }
}
