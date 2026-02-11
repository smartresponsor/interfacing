<?php
declare(strict_types=1);

namespace App\DomainInterface\Interfacing\Context;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 *
 */

/**
 *
 */
interface BaseContextProviderInterface
{
    /**
     * @return array<string, mixed>
     */
    public function provide(Request $request, ?TokenInterface $token): array;
}
