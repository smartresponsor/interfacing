<?php
    declare(strict_types=1);

    /*
     * Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
     * Proprietary and confidential.
     */

    namespace App\Service\Interfacing\Registry;

    use App\DomainInterface\Interfacing\Model\Screen\ScreenSpecInterface;
use App\ServiceInterface\Interfacing\Provider\ScreenProviderInterface;
use App\ServiceInterface\Interfacing\Registry\ScreenRegistryInterface;

    /**
     *
     */

    /**
     *
     */
    final class ScreenRegistry implements ScreenRegistryInterface
{
    /** @var array<string, ScreenSpecInterface> */
    private array $map = [];

    /** @param iterable<ScreenProviderInterface> $provider */
    public function __construct(iterable $provider)
    {
        foreach ($provider as $p) {
            foreach ($p->provide() as $screen) {
                $this->map[$screen->id()] = $screen;
            }
        }
    }

    /**
     * @return array|\App\DomainInterface\Interfacing\Model\Screen\ScreenSpecInterface[]
     */
    public function all(): array
    {
        return array_values($this->map);
    }

    /**
     * @param string $screenId
     * @return bool
     */
    public function has(string $screenId): bool
    {
        return isset($this->map[$screenId]);
    }

    /**
     * @param string $screenId
     * @return \App\DomainInterface\Interfacing\Model\Screen\ScreenSpecInterface
     */
    public function get(string $screenId): ScreenSpecInterface
    {
        if (!$this->has($screenId)) {
            throw new \InvalidArgumentException(sprintf('Unknown screenId: %s', $screenId));
        }

        return $this->map[$screenId];
    }
}

