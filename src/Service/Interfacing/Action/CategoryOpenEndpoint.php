<?php

declare(strict_types=1);

namespace App\Service\Interfacing\Action;

use App\Contract\Action\ActionRequest;
use App\Contract\Action\ActionResult;
use App\Contract\Ui\UiMessage;
use App\Contract\ValueObject\ActionId;
use App\ServiceInterface\Interfacing\ActionEndpointInterface;
use App\ServiceInterface\Interfacing\CategoryApiClientInterface;

final class CategoryOpenEndpoint implements ActionEndpointInterface
{
    public function __construct(private readonly CategoryApiClientInterface $api)
    {
    }

    public function id(): ActionId
    {
        return ActionId::of('category.open');
    }

    public function handle(ActionRequest $request): ActionResult
    {
        $id = (string) ($request->payload()['id'] ?? '');
        if ('' === $id) {
            return ActionResult::fail([], [new UiMessage('warning', 'Missing category id.')]);
        }

        try {
            return ActionResult::ok(['category' => $this->api->read($id)]);
        } catch (\Throwable $e) {
            return ActionResult::fail([], [new UiMessage('error', 'Category read failed: '.$e->getMessage())]);
        }
    }
}
