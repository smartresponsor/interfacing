    <?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Action;

    use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Action\ActionResultInterface;

interface ActionDispatcherInterface
{
    /** @param array<string, mixed> $payload
     *  @param array<string, mixed> $state
     */
    public function dispatch(string $screenId, string $actionId, array $payload, array $state): ActionResultInterface;
}

