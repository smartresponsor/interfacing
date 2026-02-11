<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace App\Service\Interfacing\Action;

    use App\ServiceInterface\Interfacing\Action\ActionEndpointInterface;
use App\ServiceInterface\Interfacing\Action\ActionRegistryInterface;
use App\ServiceInterface\Interfacing\Provider\ActionProviderInterface;

    /**
     *
     */

    /**
     *
     */
    final class ActionRegistry implements ActionRegistryInterface
{
    /** @var array<string, ActionEndpointInterface> */
    private array $map = [];

    /** @param iterable<ActionProviderInterface> $provider */
    public function __construct(iterable $provider)
    {
        foreach ($provider as $p) {
            foreach ($p->provide() as $endpoint) {
                $key = $this->key($endpoint->screenId(), $endpoint->actionId());
                $this->map[$key] = $endpoint;
            }
        }
    }

    /**
     * @param string $screenId
     * @param string $actionId
     * @return bool
     */
    public function has(string $screenId, string $actionId): bool
    {
        return isset($this->map[$this->key($screenId, $actionId)]);
    }

    /**
     * @param string $screenId
     * @return array|array[]
     */
    public function listForScreen(string $screenId): array
    {
        $out = [];
        foreach ($this->map as $endpoint) {
            if ($endpoint->screenId() === $screenId) {
                $out[] = [
                    'actionId' => $endpoint->actionId(),
                    'title' => $endpoint->title(),
                ];
            }
        }
        usort($out, static fn(array $a, array $b): int => strcmp($a['actionId'], $b['actionId']));
        return $out;
    }

    /**
     * @param string $screenId
     * @param string $actionId
     * @return \App\ServiceInterface\Interfacing\Action\ActionEndpointInterface
     */
    public function resolve(string $screenId, string $actionId): ActionEndpointInterface
    {
        $k = $this->key($screenId, $actionId);
        if (!isset($this->map[$k])) {
            throw new \InvalidArgumentException(sprintf('Unknown action: %s/%s', $screenId, $actionId));
        }
        return $this->map[$k];
    }

    /**
     * @param string $screenId
     * @param string $actionId
     * @return string
     */
    private function key(string $screenId, string $actionId): string
    {
        return $screenId . '::' . $actionId;
    }
}

