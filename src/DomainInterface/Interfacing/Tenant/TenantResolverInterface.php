<?php
declare(strict_types=1);

namespace App\DomainInterface\Interfacing\Tenant;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 *
 */

/**
 *
 */
interface TenantResolverInterface
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\Security\Core\Authentication\Token\TokenInterface|null $token
     * @return string
     */
    public function resolveTenantId(Request $request, ?TokenInterface $token): string;
}
