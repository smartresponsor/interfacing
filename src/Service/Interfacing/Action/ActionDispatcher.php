<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace App\Service\Interfacing\Action;

    use App\Domain\Interfacing\Model\Action\ActionRequest;
use App\Domain\Interfacing\Model\Action\ActionResult;
use App\DomainInterface\Interfacing\Model\Action\ActionResultInterface;
use App\ServiceInterface\Interfacing\Action\ActionDispatcherInterface;
use App\ServiceInterface\Interfacing\Action\ActionRegistryInterface;
use App\ServiceInterface\Interfacing\Context\ScreenContextAssemblerInterface;
use App\ServiceInterface\Interfacing\Registry\ScreenRegistryInterface;
use App\ServiceInterface\Interfacing\Security\AccessResolverInterface;

    /**
     *
     */

    /**
     *
     */
    final readonly class ActionDispatcher implements ActionDispatcherInterface
{
    /**
     * @param \App\ServiceInterface\Interfacing\Registry\ScreenRegistryInterface $screenRegistry
     * @param \App\ServiceInterface\Interfacing\Action\ActionRegistryInterface $actionRegistry
     * @param \App\ServiceInterface\Interfacing\Context\ScreenContextAssemblerInterface $contextAssembler
     * @param \App\ServiceInterface\Interfacing\Security\AccessResolverInterface $accessResolver
     */
    public function __construct(
        private ScreenRegistryInterface         $screenRegistry,
        private ActionRegistryInterface         $actionRegistry,
        private ScreenContextAssemblerInterface $contextAssembler,
        private AccessResolverInterface         $accessResolver,
    ) {}

    /**
     * @param string $screenId
     * @param string $actionId
     * @param array $payload
     * @param array $state
     * @return \App\Domain\Interfacing\Action\ActionResult
     */
    public function dispatch(string $screenId, string $actionId, array $payload, array $state): \App\Domain\Interfacing\Action\ActionResult
    {
        try {
            $screen = $this->screenRegistry->get($screenId);

            if (!$this->accessResolver->isAllowed($screen)) {
                return ActionResult::domainError('access_denied', 'Access denied.');
            }

            if (!$this->actionRegistry->has($screenId, $actionId)) {
                return ActionResult::domainError('unknown_action', sprintf('Unknown action: %s', $actionId));
            }

            $context = $this->contextAssembler->assemble($screenId);
            $request = new ActionRequest($screenId, $actionId, $payload, $state, $context);

            $endpoint = $this->actionRegistry->resolve($screenId, $actionId);
            return $endpoint->handle($request);
        } catch (\Throwable $e) {
            return ActionResult::domainError('action_failed', $e->getMessage());
        }
    }
}

