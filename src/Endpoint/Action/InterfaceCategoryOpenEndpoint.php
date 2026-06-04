<?php

declare(strict_types=1);

namespace App\Interfacing\Endpoint\Action;

use App\Interfacing\ClientInterface\CategoryApi\InterfaceCategoryApiClientInterface;
use App\Interfacing\Contract\Action\InterfaceActionRequest;
use App\Interfacing\Contract\Action\InterfaceActionResult;
use App\Interfacing\Contract\Ui\InterfaceUiMessage;
use App\Interfacing\Contract\ValueObject\InterfaceActionId;
use App\Interfacing\EndpointInterface\Catalog\InterfaceActionEndpointInterface;

final class InterfaceCategoryOpenEndpoint implements InterfaceActionEndpointInterface
{
    public function __construct(private readonly InterfaceCategoryApiClientInterface $api)
    {
    }

    public function id(): InterfaceActionId
    {
        return InterfaceActionId::of('category.open');
    }

    public function handle(InterfaceActionRequest $request): InterfaceActionResult
    {
        $id = (string) ($request->payload()['id'] ?? '');
        if ('' === $id) {
            return InterfaceActionResult::fail([], [new InterfaceUiMessage('warning', 'Missing category id.')]);
        }

        try {
            return InterfaceActionResult::ok(['category' => $this->api->read($id)]);
        } catch (\Throwable $e) {
            return InterfaceActionResult::fail([], [new InterfaceUiMessage('error', 'Category read failed: '.$e->getMessage())]);
        }
    }
}
