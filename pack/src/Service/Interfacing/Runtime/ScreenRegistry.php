<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace SmartResponsor\Interfacing\Service\Interfacing\Runtime;

use SmartResponsor\Interfacing\Domain\Interfacing\Model\Screen\ScreenSpec;
use SmartResponsor\Interfacing\Domain\Interfacing\Model\ScreenId;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\ScreenIdInterface;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Screen\ScreenSpecInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Runtime\ScreenRegistryInterface;

/**
 *
 */

/**
 *
 */
final class ScreenRegistry implements ScreenRegistryInterface
{
    /** @var array<string, ScreenSpecInterface> */
    private array $specById = [];

    public function __construct()
    {
        $this->registerDefault();
    }

    /**
     * @return void
     */
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

    /**
     * @param \SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Screen\ScreenSpecInterface $spec
     * @return void
     */
    public function register(ScreenSpecInterface $spec): void
    {
        $this->specById[$spec->getId()->toString()] = $spec;
    }

    /**
     * @param \SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\ScreenIdInterface $id
     * @return bool
     */
    public function has(ScreenIdInterface $id): bool
    {
        return isset($this->specById[$id->toString()]);
    }

    /**
     * @param \SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\ScreenIdInterface $id
     * @return \SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Screen\ScreenSpecInterface
     */
    public function get(ScreenIdInterface $id): ScreenSpecInterface
    {
        $key = $id->toString();
        if (!isset($this->specById[$key])) {
            throw new \RuntimeException('Unknown screenId: ' . $key);
        }
        return $this->specById[$key];
    }

    /**
     * @return array|\SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Screen\ScreenSpecInterface[]
     */
    public function all(): array
    {
        return array_values($this->specById);
    }
}
