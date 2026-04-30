<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Action;

use App\Interfacing\Contract\Action\ActionRequest;
use App\Interfacing\Contract\Action\ActionResult;
use App\Interfacing\Contract\Ui\UiMessage;
use App\Interfacing\Contract\ValueObject\ActionId;
use App\Interfacing\ServiceInterface\Interfacing\ActionEndpointInterface;
use App\Interfacing\ServiceInterface\Interfacing\CategoryApiClientInterface;

final class CategoryListEndpoint implements ActionEndpointInterface
{
    public function __construct(private readonly CategoryApiClientInterface $api)
    {
    }

    public function id(): ActionId
    {
        return ActionId::of('category.list');
    }

    public function handle(ActionRequest $request): ActionResult
    {
        $q = (string) ($request->payload()['q'] ?? '');
        $cursor = $request->payload()['cursor'] ?? null;
        $limit = (int) ($request->payload()['limit'] ?? 25);

        try {
            $out = $this->api->list($q, is_string($cursor) ? $cursor : null, max(1, min(100, $limit)));

            return ActionResult::ok(['item' => array_map(static fn ($v) => $v->toArray(), $out['item']), 'nextCursor' => $out['nextCursor']]);
        } catch (\Throwable $e) {
            return ActionResult::fail([], [new UiMessage('error', 'Category list failed: '.$e->getMessage())]);
        }
    }
}
