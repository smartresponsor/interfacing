<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace App\Service\Interfacing\Runtime;

use App\Domain\Interfacing\Model\Screen\ScreenSpec;
use App\Domain\Interfacing\Model\ScreenId;
use App\DomainInterface\Interfacing\Model\ScreenIdInterface;
use App\DomainInterface\Interfacing\Model\Screen\ScreenSpecInterface;
use App\ServiceInterface\Interfacing\Runtime\ScreenRegistryInterface;

final class ScreenRegistry implements ScreenRegistryInterface
{
    /** @var array<string, ScreenSpecInterface> */
    private array $specById = [];

    public function __construct()
    {
        $this->registerDefault();
    }

    private function registerDefault(): void
    {
        $this->register(
            ScreenSpec::create(
                ScreenId::fromString('screen-empty'),
                'Empty',
                'interfacing/screen/screen-empty.html.twig'
            )
        );

        $this->register(
            ScreenSpec::create(
                ScreenId::fromString('screen-home'),
                'Home',
                'interfacing/screen/screen-home.html.twig'
            )
        );

        $this->register(
            ScreenSpec::create(
                ScreenId::fromString('screen-health'),
                'Health',
                'interfacing/screen/screen-health.html.twig'
            )
        );
    }

    public function register(ScreenSpecInterface $spec): void
    {
        $this->specById[$spec->getId()->toString()] = $spec;
    }

    public function has(ScreenIdInterface $id): bool
    {
        return isset($this->specById[$id->toString()]);
    }

    public function get(ScreenIdInterface $id): ScreenSpecInterface
    {
        $key = $id->toString();
        if (!isset($this->specById[$key])) {
            throw new \RuntimeException('Unknown screenId: ' . $key);
        }
        return $this->specById[$key];
    }

    public function all(): array
    {
        return array_values($this->specById);
    }
}
