<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Contract\View;

final class DataGridQuery
{
    public function __construct(
        private readonly string $search = '',
        private readonly string $sortKey = 'id',
        private string $sortDir = 'asc',
        private int $page = 1,
        private int $pageSize = 10,
    ) {
        $this->page = max(1, $this->page);
        $this->pageSize = min(100, max(1, $this->pageSize));
        $this->sortDir = 'desc' === strtolower($this->sortDir) ? 'desc' : 'asc';
    }

    public function search(): string
    {
        return $this->search;
    }

    public function sortKey(): string
    {
        return $this->sortKey;
    }

    public function sortDir(): string
    {
        return $this->sortDir;
    }

    public function page(): int
    {
        return $this->page;
    }

    public function pageSize(): int
    {
        return $this->pageSize;
    }

    public function withPage(int $page): self
    {
        return new self($this->search, $this->sortKey, $this->sortDir, $page, $this->pageSize);
    }

    public function withSearch(string $search): self
    {
        return new self($search, $this->sortKey, $this->sortDir, $this->page, $this->pageSize);
    }

    public function withSort(string $key, string $dir): self
    {
        return new self($this->search, $key, $dir, $this->page, $this->pageSize);
    }
}
