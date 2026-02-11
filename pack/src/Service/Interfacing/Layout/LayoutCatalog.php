<?php
declare(strict_types=1);

/*
 * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
 */
namespace SmartResponsor\Interfacing\Service\Interfacing\Layout;

use SmartResponsor\Interfacing\Domain\Interfacing\Model\Layout\LayoutScreenSpec;
use SmartResponsor\Interfacing\Domain\Interfacing\Model\ScreenId;
use SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Layout\LayoutScreenSpecInterface;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\Layout\LayoutCatalogInterface;

/**
 *
 */

/**
 *
 */
final class LayoutCatalog implements LayoutCatalogInterface
{
    /** @var array<string, LayoutScreenSpecInterface> */
    private array $specBySlug = [];

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
            LayoutScreenSpec::create(
                'home',
                'Home',
                'tool',
                ScreenId::fromString('screen-home')
            )
        );

        $this->register(
            LayoutScreenSpec::create(
                'health',
                'Health',
                'tool',
                ScreenId::fromString('screen-health')
            )
        );

        $this->register(
            LayoutScreenSpec::create(
                'empty',
                'Empty',
                'tool',
                ScreenId::fromString('screen-empty')
            )
        );
    }

    /**
     * @param \SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Layout\LayoutScreenSpecInterface $spec
     * @return void
     */
    public function register(LayoutScreenSpecInterface $spec): void
    {
        $this->specBySlug[$spec->getSlug()] = $spec;
    }

    /**
     * @param string $slug
     * @return bool
     */
    public function hasSlug(string $slug): bool
    {
        return isset($this->specBySlug[$slug]);
    }

    /**
     * @param string $slug
     * @return \SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Layout\LayoutScreenSpecInterface
     */
    public function getBySlug(string $slug): LayoutScreenSpecInterface
    {
        if (!isset($this->specBySlug[$slug])) {
            throw new \RuntimeException('Unknown layout slug: ' . $slug);
        }
        return $this->specBySlug[$slug];
    }

    /**
     * @return array|\SmartResponsor\Interfacing\DomainInterface\Interfacing\Model\Layout\LayoutScreenSpecInterface[]
     */
    public function all(): array
    {
        return array_values($this->specBySlug);
    }
}
