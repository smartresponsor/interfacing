<?php

declare(strict_types=1);

namespace App\Interfacing\ServiceInterface\Interfacing\Tenant;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

interface TenantResolverInterface
{
    public function resolveTenantId(Request $request, ?TokenInterface $token): string;
}
