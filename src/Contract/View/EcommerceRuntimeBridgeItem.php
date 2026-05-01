<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\View;

final readonly class EcommerceRuntimeBridgeItem
{
    /**
     * @param list<string> $routeBridge
     * @param list<string> $controllerBridge
     * @param list<string> $queryBridge
     * @param list<string> $commandBridge
     * @param list<string> $policyBridge
     * @param list<string> $evidenceBridge
     */
    public function __construct(
        private string $id,
        private string $zone,
        private string $component,
        private string $status,
        private string $bridgeGrade,
        private string $primaryUrl,
        private array $routeBridge,
        private array $controllerBridge,
        private array $queryBridge,
        private array $commandBridge,
        private array $policyBridge,
        private array $evidenceBridge,
        private string $promotionGate,
        private string $note,
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function zone(): string
    {
        return $this->zone;
    }

    public function component(): string
    {
        return $this->component;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function bridgeGrade(): string
    {
        return $this->bridgeGrade;
    }

    public function primaryUrl(): string
    {
        return $this->primaryUrl;
    }

    /** @return list<string> */
    public function routeBridge(): array
    {
        return $this->routeBridge;
    }

    /** @return list<string> */
    public function controllerBridge(): array
    {
        return $this->controllerBridge;
    }

    /** @return list<string> */
    public function queryBridge(): array
    {
        return $this->queryBridge;
    }

    /** @return list<string> */
    public function commandBridge(): array
    {
        return $this->commandBridge;
    }

    /** @return list<string> */
    public function policyBridge(): array
    {
        return $this->policyBridge;
    }

    /** @return list<string> */
    public function evidenceBridge(): array
    {
        return $this->evidenceBridge;
    }

    public function promotionGate(): string
    {
        return $this->promotionGate;
    }

    public function note(): string
    {
        return $this->note;
    }
}
