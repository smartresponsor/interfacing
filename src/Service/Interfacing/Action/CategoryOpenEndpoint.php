<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Service\Interfacing\Action;

use App\Domain\Interfacing\Model\ActionRequest;
use App\Domain\Interfacing\Model\ActionResult;
use App\Domain\Interfacing\Model\UiMessage;
use App\Domain\Interfacing\Value\ActionId;
use App\ServiceInterface\Interfacing\ActionEndpointInterface;
use App\ServiceInterface\Interfacing\CategoryApiClientInterface;

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
