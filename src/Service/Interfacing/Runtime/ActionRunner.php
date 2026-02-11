<?php
    declare(strict_types=1);

    /* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

    namespace App\Service\Interfacing\Runtime;

    use App\ServiceInterface\Interfacing\Registry\ActionCatalogInterface;
use App\ServiceInterface\Interfacing\Runtime\ActionRequest;
use App\ServiceInterface\Interfacing\Runtime\ActionResult;
use App\ServiceInterface\Interfacing\Runtime\ActionRunnerInterface;
use Symfony\Component\HttpFoundation\Request;

final class ActionRunner implements ActionRunnerInterface
{
    public function __construct(
        private readonly ActionCatalogInterface $actionCatalog,
    ) {
    }

    public function run(string $screenId, string $actionId, array $payload, Request $request): ActionResult
    {
        $endpoint = $this->actionCatalog->get($screenId, $actionId);
        return $endpoint->handle(new ActionRequest($screenId, $actionId, $payload, $request));
    }
}

