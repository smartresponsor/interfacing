<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Service\Interfacing\Widget\DataGrid\Demo;

use App\Domain\Interfacing\Model\DataGrid\DataGridQuery;
use App\Domain\Interfacing\Model\DataGrid\DataGridResult;
use App\Domain\Interfacing\Model\DataGrid\DataGridRow;
use App\ServiceInterface\Interfacing\Widget\DataGrid\DataGridProviderInterface;

/**
 *
 */

/**
 *
 */
final class DemoDataGridProvider implements DataGridProviderInterface
{
    /**
     * @return string
     */
    public function key(): string
    {
        return 'demo';
    }

    /**
     * @param \App\Domain\Interfacing\Model\DataGrid\DataGridQuery $query
     * @param array $context
     * @return \App\Domain\Interfacing\Model\DataGrid\DataGridResult
     */
    public function fetch(DataGridQuery $query, array $context = []): DataGridResult
    {
        $item = $this->seed();

        $search = strtolower(trim($query->search()));
        if ($search !== '') {
            $item = array_values(array_filter($item, static function (array $x) use ($search): bool {
                return str_contains(strtolower($x['id']), $search)
                    || str_contains(strtolower($x['name']), $search)
                    || str_contains(strtolower($x['status']), $search);
            }));
        }

        $sortKey = $query->sortKey();
        $sortDir = $query->sortDir();
        usort($item, static function (array $a, array $b) use ($sortKey, $sortDir): int {
            $av = (string)($a[$sortKey] ?? '');
            $bv = (string)($b[$sortKey] ?? '');
            $cmp = strcmp($av, $bv);
            return $sortDir === 'desc' ? -$cmp : $cmp;
        });

        $total = count($item);
        $offset = ($query->page() - 1) * $query->pageSize();
        $pageItem = array_slice($item, $offset, $query->pageSize());

        $row = [];
        foreach ($pageItem as $x) {
            $row[] = new DataGridRow((string)$x['id'], [
                'id' => (string)$x['id'],
                'name' => (string)$x['name'],
                'status' => (string)$x['status'],
                'updatedAt' => (string)$x['updatedAt'],
            ]);
        }

        return new DataGridResult($row, $query->page(), $query->pageSize(), $total);
    }

    /**
     * @return list<array{id:string,name:string,status:string,updatedAt:string}>
     * @throws \DateInvalidOperationException
     * @throws \DateInvalidOperationException
     */
    private function seed(): array
    {
        $out = [];
        $now = new \DateTimeImmutable('now');
        for ($i = 1; $i <= 57; $i++) {
            $out[] = [
                'id' => (string)$i,
                'name' => 'Demo item '.$i,
                'status' => ($i % 3 === 0) ? 'pending' : (($i % 2 === 0) ? 'done' : 'open'),
                'updatedAt' => $now->sub(new \DateInterval('PT'.($i * 7).'M'))->format('Y-m-d H:i'),
            ];
        }
        return $out;
    }
}
