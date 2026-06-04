<?php

declare(strict_types=1);

namespace App\Interfacing\Endpoint\Action;

use App\Interfacing\ClientInterface\CategoryApi\InterfaceCategoryApiClientInterface;
use App\Interfacing\Contract\Action\InterfaceActionRequest;
use App\Interfacing\Contract\Action\InterfaceActionResult;
use App\Interfacing\Contract\Ui\InterfaceUiMessage;
use App\Interfacing\Contract\ValueObject\InterfaceActionId;
use App\Interfacing\EndpointInterface\Catalog\InterfaceActionEndpointInterface;

final class InterfaceCategoryListEndpoint implements InterfaceActionEndpointInterface
{
    public function __construct(private readonly InterfaceCategoryApiClientInterface $api)
    {
    }

    public function id(): InterfaceActionId
    {
        return InterfaceActionId::of('category.list');
    }

    public function handle(InterfaceActionRequest $request): InterfaceActionResult
    {
        $q = (string) ($request->payload()['q'] ?? '');
        $cursor = $request->payload()['cursor'] ?? null;
        $limit = (int) ($request->payload()['limit'] ?? 25);

        try {
            $out = $this->api->list($q, is_string($cursor) ? $cursor : null, max(1, min(100, $limit)));

            return InterfaceActionResult::ok(['item' => array_map(static fn ($v) => $v->toArray(), $out['item']), 'nextCursor' => $out['nextCursor']]);
        } catch (\Throwable $e) {
            return InterfaceActionResult::fail([], [new InterfaceUiMessage('error', 'Category list failed: '.$e->getMessage())]);
        }
    }
}
