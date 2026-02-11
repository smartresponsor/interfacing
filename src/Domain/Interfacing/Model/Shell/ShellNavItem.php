<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Domain\Interfacing\Model\Shell;

use App\DomainInterface\Interfacing\Model\Shell\ShellNavItemInterface;

/**
 *
 */

/**
 *
 */
final class ShellNavItem implements ShellNavItemInterface
{
    /**
     * @param string $id
     * @param string $title
     * @param string $url
     * @param string $group
     * @param string|null $icon
     * @param int $order
     */
    public function __construct(
        private string           $id,
        private readonly string  $title,
        private string           $url,
        private string           $group,
        private readonly ?string $icon = null,
        private int              $order = 100,
    ) {
        $this->id = trim($this->id);
        if ($this->id === '') {
            throw new \InvalidArgumentException('ShellNavItem id must be non-empty.');
        }
        $this->group = trim($this->group) !== '' ? trim($this->group) : 'tool';
        $this->url = trim($this->url);
        if ($this->url === '') {
            throw new \InvalidArgumentException('ShellNavItem url must be non-empty.');
        }
        $this->order = max(-100000, min(100000, $this->order));
    }

    /**
     * @return string
     */
    public function id(): string { return $this->id; }

    /**
     * @return string
     */
    public function title(): string { return $this->title; }

    /**
     * @return string
     */
    public function url(): string { return $this->url; }

    /**
     * @return string
     */
    public function group(): string { return $this->group; }

    /**
     * @return string|null
     */
    public function icon(): ?string { return $this->icon; }

    /**
     * @return int
     */
    public function order(): int { return $this->order; }
}
