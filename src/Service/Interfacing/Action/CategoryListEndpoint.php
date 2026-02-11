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

final class CategoryListEndpoint implements ActionEndpointInterface
{
    public function __construct(private CategoryApiClientInterface $api) {}

    public function id(): ActionId { return ActionId::of('category.list'); }

    public function handle(ActionRequest $request): ActionResult
    {
        $q = (string)($request->payload()['q'] ?? '');
        $cursor = $request->payload()['cursor'] ?? null;
        $limit = (int)($request->payload()['limit'] ?? 25);

        try {
            $out = $this->api->list($q, is_string($cursor) ? $cursor : null, max(1, min(100, $limit)));
            $item = array_map(static fn($v) => $v->toArray(), $out['item']);
            return ActionResult::ok([], ['item' => $item, 'nextCursor' => $out['nextCursor']]);
        } catch (\Throwable $e) {
            return ActionResult::domainError([UiMessage::error('Category list failed: '.$e->getMessage())]);
        }
    }
}
