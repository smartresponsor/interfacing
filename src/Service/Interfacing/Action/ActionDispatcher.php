<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Action;

use App\Interfacing\ServiceInterface\Interfacing\Action\ActionDispatcherInterface;
use App\Interfacing\ServiceInterface\Interfacing\Action\ActionRegistryInterface;
use App\Interfacing\ServiceInterface\Interfacing\Context\ScreenContextAssemblerInterface;
use App\Interfacing\ServiceInterface\Interfacing\Registry\ScreenRegistryInterface;
use App\Interfacing\ServiceInterface\Interfacing\Runtime\ActionRequest;
use App\Interfacing\ServiceInterface\Interfacing\Runtime\ActionResult;
use App\Interfacing\ServiceInterface\Interfacing\Security\ScreenAccessResolverInterface;

final readonly class ActionDispatcher implements ActionDispatcherInterface
{
    public function __construct(
        private ScreenRegistryInterface $screenRegistry,
        private ActionRegistryInterface $actionRegistry,
        private ScreenContextAssemblerInterface $contextAssembler,
        private ScreenAccessResolverInterface $accessResolver,
    ) {
    }

    public function dispatch(string $screenId, string $actionId, array $payload, array $state): ActionResult
    {
        try {
            $screen = $this->screenRegistry->get($screenId);

            if (!$this->accessResolver->isAllowed($screen)) {
                return ActionResult::domainError('Access denied.');
            }

            if (!$this->actionRegistry->has($screenId, $actionId)) {
                return ActionResult::domainError(sprintf('Unknown action: %s', $actionId));
            }

            $context = $this->contextAssembler->assemble($screenId);
            $request = new ActionRequest($screenId, $actionId, $payload, $state, $context);

            $endpoint = $this->actionRegistry->resolve($screenId, $actionId);

            return $endpoint->handle($request);
        } catch (\Throwable $e) {
            return ActionResult::domainError($e->getMessage());
        }
    }
}
