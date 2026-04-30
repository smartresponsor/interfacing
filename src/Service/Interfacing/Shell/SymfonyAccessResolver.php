<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Service\Interfacing\Shell;

use App\Interfacing\ServiceInterface\Interfacing\Shell\AccessResolverInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 *
 */

/**
 *
 */
final class SymfonyAccessResolver implements AccessResolverInterface
{
    /**
     * @param \Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface|null $auth
     */
    public function __construct(private readonly ?AuthorizationCheckerInterface $auth = null)
    {
    }

    /**
     * @param string $capability
     * @param array $context
     * @return bool
     */
    public function allow(string $capability, array $context = []): bool
    {
        $capability = trim($capability);
        if ($capability === '') {
            return true;
        }

        if ($this->auth === null) {
            return true;
        }

        [$attr, $subject] = $this->parse($capability, $context);

        return $this->auth->isGranted($attr, $subject);
    }

    /**
     * @param array<string,mixed> $context
     * @return array{0:string,1:mixed}
     */
    private function parse(string $capability, array $context): array
    {
        $subject = $context['subject'] ?? null;

        if (str_starts_with($capability, 'role:')) {
            $role = trim(substr($capability, 5));
            return [$role !== '' ? $role : $capability, $subject];
        }

        if (str_starts_with($capability, 'attr:')) {
            $attr = trim(substr($capability, 5));
            return [$attr !== '' ? $attr : $capability, $subject];
        }

        return [$capability, $subject];
    }
}
