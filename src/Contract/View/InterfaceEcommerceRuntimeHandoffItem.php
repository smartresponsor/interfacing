<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\View;

final readonly class InterfaceEcommerceRuntimeHandoffItem
{
    /**
     * @param list<string> $routeHandoff
     * @param list<string> $controllerHandoff
     * @param list<string> $queryHandoff
     * @param list<string> $commandHandoff
     * @param list<string> $policyHandoff
     * @param list<string> $evidenceHandoff
     */
    public function __construct(
        private string $id,
        private string $zone,
        private string $component,
        private string $status,
        private string $handoffGrade,
        private string $primaryUrl,
        private array $routeHandoff,
        private array $controllerHandoff,
        private array $queryHandoff,
        private array $commandHandoff,
        private array $policyHandoff,
        private array $evidenceHandoff,
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

    public function handoffGrade(): string
    {
        return $this->handoffGrade;
    }

    public function primaryUrl(): string
    {
        return $this->primaryUrl;
    }

    /** @return list<string> */
    public function routeHandoff(): array
    {
        return $this->routeHandoff;
    }

    /** @return list<string> */
    public function controllerHandoff(): array
    {
        return $this->controllerHandoff;
    }

    /** @return list<string> */
    public function queryHandoff(): array
    {
        return $this->queryHandoff;
    }

    /** @return list<string> */
    public function commandHandoff(): array
    {
        return $this->commandHandoff;
    }

    /** @return list<string> */
    public function policyHandoff(): array
    {
        return $this->policyHandoff;
    }

    /** @return list<string> */
    public function evidenceHandoff(): array
    {
        return $this->evidenceHandoff;
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
