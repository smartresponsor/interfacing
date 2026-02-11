<?php
declare(strict_types=1);

namespace App\DomainInterface\Interfacing\Access;

use App\Domain\Interfacing\Access\AccessDecision;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 *
 */

/**
 *
 */
interface AccessResolverInterface
{
    /**
     * @param string $screenId
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\Security\Core\Authentication\Token\TokenInterface|null $token
     * @return \App\Domain\Interfacing\Access\AccessDecision
     */
    public function canOpenScreen(string $screenId, Request $request, ?TokenInterface $token): AccessDecision;

    /**
     * @param string $screenId
     * @param string $actionId
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\Security\Core\Authentication\Token\TokenInterface|null $token
     * @return \App\Domain\Interfacing\Access\AccessDecision
     */
    public function canRunAction(string $screenId, string $actionId, Request $request, ?TokenInterface $token): AccessDecision;
}
