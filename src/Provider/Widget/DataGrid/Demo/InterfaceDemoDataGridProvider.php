<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/

namespace App\Interfacing\Provider\Widget\DataGrid\Demo;

use App\Interfacing\Contract\View\InterfaceDataGridQuery;
use App\Interfacing\Contract\View\InterfaceDataGridResult;
use App\Interfacing\Contract\View\InterfaceDataGridRow;
use App\Interfacing\ProviderInterface\Widget\DataGrid\InterfaceDataGridProviderInterface;

final class InterfaceDemoDataGridProvider implements InterfaceDataGridProviderInterface
{
    public function key(): string
    {
        return 'demo';
    }

    /** @param array<string, mixed> $context */
    public function fetch(InterfaceDataGridQuery $query, array $context = []): InterfaceDataGridResult
    {
        $item = $this->seed();

        $search = mb_strtolower(trim($query->search()));
        if ('' !== $search) {
            $item = array_values(array_filter($item, static function (array $row) use ($search): bool {
                $haystack = mb_strtolower((string) ($row['id'].' '.$row['nameEntity'].' '.$row['status'].' '.$row['updatedAt']));

                return str_contains($haystack, $search);
            }));
        }

        $sortKey = $query->sortKey();
        $sortDir = $query->sortDir();
        usort($item, static function (array $a, array $b) use ($sortKey, $sortDir): int {
            $av = (string) ($a[$sortKey] ?? '');
            $bv = (string) ($b[$sortKey] ?? '');
            $cmp = strcmp($av, $bv);

            return 'desc' === $sortDir ? -$cmp : $cmp;
        });

        $total = count($item);
        $offset = max(0, ($query->page() - 1) * $query->pageSize());
        $pageItem = array_slice($item, $offset, $query->pageSize());

        $row = [];
        foreach ($pageItem as $entry) {
            $row[] = new InterfaceDataGridRow((string) $entry['id'], [
                'id' => (string) $entry['id'],
                'nameEntity' => (string) $entry['nameEntity'],
                'status' => (string) $entry['status'],
                'updatedAt' => (string) $entry['updatedAt'],
            ]);
        }

        return new InterfaceDataGridResult($row, $query->page(), $query->pageSize(), $total);
    }

    /** @return list<array{id:string,name:string,status:string,updatedAt:string}> */
    private function seed(): array
    {
        $out = [];
        $now = new \DateTimeImmutable('now');

        for ($i = 1; $i <= 57; ++$i) {
            $out[] = [
                'id' => (string) $i,
                'nameEntity' => 'Demo item '.$i,
                'status' => (0 === $i % 3) ? 'pending' : ((0 === $i % 2) ? 'done' : 'open'),
                'updatedAt' => $now->sub(new \DateInterval('PT'.($i * 7).'M'))->format('Y-m-d H:i'),
            ];
        }

        return $out;
    }
}
