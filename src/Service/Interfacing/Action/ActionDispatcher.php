    <?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace SmartResponsor\Interfacing\Service\Interfacing\Action;

    use SmartResponsor\Interfacing\Domain\Interfacing\Model\Action\ActionRequest;
use SmartResponsor\Interfacing\Domain\Interfacing\Model\Action\ActionResult;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Action\ActionResultInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Action\ActionDispatcherInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Action\ActionRegistryInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Context\ScreenContextAssemblerInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Registry\ScreenRegistryInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Security\AccessResolverInterface;

final class ActionDispatcher implements ActionDispatcherInterface
{
    public function __construct(
        private readonly ScreenRegistryInterface $screenRegistry,
        private readonly ActionRegistryInterface $actionRegistry,
        private readonly ScreenContextAssemblerInterface $contextAssembler,
        private readonly AccessResolverInterface $accessResolver,
    ) {}

    public function dispatch(string $screenId, string $actionId, array $payload, array $state): ActionResultInterface
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

