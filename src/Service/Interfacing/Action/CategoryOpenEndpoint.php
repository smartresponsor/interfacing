<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace SmartResponsor\Interfacing\Service\Interfacing\Action;

use SmartResponsor\Interfacing\Domain\Interfacing\Model\ActionRequest;
use SmartResponsor\Interfacing\Domain\Interfacing\Model\ActionResult;
use SmartResponsor\Interfacing\Domain\Interfacing\Model\UiMessage;
use SmartResponsor\Interfacing\Domain\Interfacing\Value\ActionId;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\ActionEndpointInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\CategoryApiClientInterface;

final class CategoryOpenEndpoint implements ActionEndpointInterface
{
    public function __construct(private CategoryApiClientInterface $api) {}

    public function id(): ActionId { return ActionId::of('category.open'); }

    public function handle(ActionRequest $request): ActionResult
    {
        $id = (string)($request->payload()['id'] ?? '');
        if ($id === '') {
            return ActionResult::domainError([UiMessage::warning('Missing category id.')]);
        }

        try {
            return ActionResult::ok([], ['category' => $this->api->read($id)]);
        } catch (\Throwable $e) {
            return ActionResult::domainError([UiMessage::error('Category read failed: '.$e->getMessage())]);
        }
    }
}
