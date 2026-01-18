    <?php
    declare(strict_types=1);

    /* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

    namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Registry;

    use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Runtime\ActionRequest;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Runtime\ActionResult;

interface ActionEndpointInterface
{
    public function screenId(): string;

    public function actionId(): string;

    public function title(): string;

    public function order(): int;

    public function handle(ActionRequest $request): ActionResult;
}

