<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Domain\Interfacing\Model\DataGrid;

/**
 *
 */

/**
 *
 */
final class DataGridQuery
{
    /**
     * @param string $search
     * @param string $sortKey
     * @param string $sortDir
     * @param int $page
     * @param int $pageSize
     */
    public function __construct(
        private readonly string $search = '',
        private readonly string $sortKey = 'id',
        private string          $sortDir = 'asc',
        private int             $page = 1,
        private int             $pageSize = 10,
    ) {
        $this->page = max(1, $this->page);
        $this->pageSize = min(100, max(1, $this->pageSize));
        $this->sortDir = strtolower($this->sortDir) === 'desc' ? 'desc' : 'asc';
    }

    /**
     * @return string
     */
    public function search(): string
    {
        return $this->search;
    }

    /**
     * @return string
     */
    public function sortKey(): string
    {
        return $this->sortKey;
    }

    /**
     * @return string
     */
    public function sortDir(): string
    {
        return $this->sortDir;
    }

    /**
     * @return int
     */
    public function page(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function pageSize(): int
    {
        return $this->pageSize;
    }

    /**
     * @param int $page
     * @return self
     */
    public function withPage(int $page): self
    {
        return new self($this->search, $this->sortKey, $this->sortDir, $page, $this->pageSize);
    }

    /**
     * @param string $search
     * @return self
     */
    public function withSearch(string $search): self
    {
        return new self($search, $this->sortKey, $this->sortDir, $this->page, $this->pageSize);
    }

    /**
     * @param string $key
     * @param string $dir
     * @return self
     */
    public function withSort(string $key, string $dir): self
    {
        return new self($this->search, $key, $dir, $this->page, $this->pageSize);
    }
}
