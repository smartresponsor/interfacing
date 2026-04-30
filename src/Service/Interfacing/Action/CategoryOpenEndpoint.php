<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Action;

use App\Interfacing\Contract\Action\ActionRequest;
use App\Interfacing\Contract\Action\ActionResult;
use App\Interfacing\Contract\Ui\UiMessage;
use App\Interfacing\Contract\ValueObject\ActionId;
use App\Interfacing\ServiceInterface\Interfacing\ActionEndpointInterface;
use App\Interfacing\ServiceInterface\Interfacing\CategoryApiClientInterface;

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
