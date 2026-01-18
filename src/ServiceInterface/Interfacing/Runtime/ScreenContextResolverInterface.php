<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\ServiceInterface\Interfacing\Runtime;

use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Layout\LayoutScreenSpecInterface;

interface ScreenContextResolverInterface
{
    public function id(): string;

    public function supports(LayoutScreenSpecInterface $spec): bool;

    /**
     * @param array<string,mixed> $context
     * @return array<string,mixed>
     */
    public function resolve(LayoutScreenSpecInterface $spec, array $context): array;
}
