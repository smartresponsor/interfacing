<?php

declare(strict_types=1);

namespace App\Interfacing\Dispatcher\Action;

use App\Interfacing\AssemblerInterface\Context\InterfaceScreenContextAssemblerInterface;
use App\Interfacing\Contract\Runtime\InterfaceActionRequest;
use App\Interfacing\Contract\Runtime\InterfaceActionResult;
use App\Interfacing\DispatcherInterface\Action\InterfaceActionDispatcherInterface;
use App\Interfacing\RegistryInterface\Action\InterfaceActionRegistryInterface;
use App\Interfacing\RegistryInterface\AttributeRegistry\InterfaceScreenRegistryInterface;
use App\Interfacing\ResolverInterface\Security\InterfaceScreenAccessResolverInterface;

final readonly class InterfaceActionDispatcher implements InterfaceActionDispatcherInterface
{
    public function __construct(
        private InterfaceScreenRegistryInterface $screenRegistry,
        private InterfaceActionRegistryInterface $actionRegistry,
        private InterfaceScreenContextAssemblerInterface $contextAssembler,
        private InterfaceScreenAccessResolverInterface $accessResolver,
    ) {
    }

    public function dispatch(string $screenId, string $actionId, array $payload, array $state): InterfaceActionResult
    {
        try {
            $screen = $this->screenRegistry->get($screenId);

            if (!$this->accessResolver->isAllowed($screen)) {
                return InterfaceActionResult::domainError('Access denied.');
            }

            if (!$this->actionRegistry->has($screenId, $actionId)) {
                return InterfaceActionResult::domainError(sprintf('Unknown action: %s', $actionId));
            }

            $context = $this->contextAssembler->assemble($screenId);
            $request = new InterfaceActionRequest($screenId, $actionId, $payload, $state, $context);

            $endpoint = $this->actionRegistry->resolve($screenId, $actionId);

            return $endpoint->handle($request);
        } catch (\Throwable $e) {
            return InterfaceActionResult::domainError($e->getMessage());
        }
    }
}
