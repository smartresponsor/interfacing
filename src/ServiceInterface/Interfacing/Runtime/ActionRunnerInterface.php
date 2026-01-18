    <?php
    declare(strict_types=1);

    /* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

    namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Runtime;

    use Symfony\Component\HttpFoundation\Request;

interface ActionRunnerInterface
{
    /**
     * @param array<string, mixed> $payload
     */
    public function run(string $screenId, string $actionId, array $payload, Request $request): ActionResult;
}

