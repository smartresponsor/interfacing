<?php

declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 * Proprietary and confidential.
 */

namespace App\Interfacing\Presentation\LiveComponent\Interfacing;

use App\Interfacing\Contract\View\ScreenSpecInterface;
use App\Interfacing\ServiceInterface\Interfacing\Action\ActionDispatcherInterface;
use App\Interfacing\ServiceInterface\Interfacing\Registry\ScreenRegistryInterface;
use App\Interfacing\ServiceInterface\Interfacing\Runtime\ActionResult;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

#[AsLiveComponent('interfacing_screen', template: 'interfacing/live/screen.html.twig')]
final class ScreenLiveComponent
{
    #[LiveProp]
    public string $screenId = 'demo.form';

    /** @var array<string, mixed> */
    #[LiveProp(writable: true)]
    public array $state = [];

    /** @var array<int, array{type:string, message:string}> */
    #[LiveProp(writable: true)]
    public array $flash = [];

    /** @var array<string, string> */
    #[LiveProp(writable: true)]
    public array $fieldError = [];

    /** @var array<int, string> */
    #[LiveProp(writable: true)]
    public array $globalError = [];

    #[LiveProp(writable: true)]
    public ?string $domainError = null;

    public function __construct(
        private readonly ScreenRegistryInterface $screenRegistry,
        private readonly ActionDispatcherInterface $actionDispatcher,
    ) {
    }

    public function __invoke(): void
    {
    }

    public function mount(): void
    {
        if ([] !== $this->state) {
            return;
        }

        $screen = $this->screenRegistry->get($this->screenId);
        $this->state = $screen->defaultState();
        $this->flash = (array) ($this->state['flash'] ?? []);
        $this->fieldError = (array) ($this->state['fieldError'] ?? []);
        $this->globalError = (array) ($this->state['globalError'] ?? []);
    }

    public function screen(): ScreenSpecInterface
    {
        return $this->screenRegistry->get($this->screenId);
    }

    #[LiveAction]
    public function invokeAction(string $actionId, array $payload = []): void
    {
        $result = $this->actionDispatcher->dispatch($this->screenId, $actionId, $payload, $this->state);

        if (ActionResult::TYPE_OK === $result->type()) {
            $patch = (array) ($result->payload()['patch'] ?? []);
            $flash = (array) ($result->payload()['flash'] ?? []);
            $this->applyPatch($patch);
            foreach ($flash as $msg) {
                if (is_array($msg) && isset($msg['type'], $msg['message'])) {
                    $this->flash[] = ['type' => (string) $msg['type'], 'message' => (string) $msg['message']];
                }
            }
            $this->domainError = null;

            return;
        }

        if (ActionResult::TYPE_VALIDATION_ERROR === $result->type()) {
            $this->fieldError = (array) ($result->payload()['fieldError'] ?? []);
            $this->globalError = (array) ($result->payload()['globalError'] ?? []);
            $this->domainError = null;

            return;
        }

        if (ActionResult::TYPE_DOMAIN_ERROR === $result->type()) {
            $this->domainError = (string) ($result->payload()['message'] ?? 'Domain error.');

            return;
        }

        if (ActionResult::TYPE_RELOAD === $result->type()) {
            $this->state = $this->screen()->defaultState();

            return;
        }

        if (ActionResult::TYPE_REDIRECT === $result->type()) {
            $this->domainError = 'Redirect requested: '.($result->payload()['url'] ?? '');
        }
    }

    /** @param array<string, mixed> $patch */
    private function applyPatch(array $patch): void
    {
        foreach ($patch as $k => $v) {
            $this->state[$k] = $v;
        }

        $this->flash = (array) ($this->state['flash'] ?? $this->flash);
        $this->fieldError = (array) ($this->state['fieldError'] ?? $this->fieldError);
        $this->globalError = (array) ($this->state['globalError'] ?? $this->globalError);
    }
}
