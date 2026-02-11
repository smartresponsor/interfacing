<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Service\Interfacing\Widget\DataGrid\Provider;

use App\Domain\Interfacing\Model\DataGrid\DataGridColumnSpec;
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
    public function alias(): string
    {
        return 'demo';
    }

    /**
     * @param \App\Domain\Interfacing\Model\DataGrid\DataGridQuery $query
     * @return \App\Domain\Interfacing\Model\DataGrid\DataGridResult
     */
    public function provide(DataGridQuery $query): DataGridResult
    {
        $column = [
            new DataGridColumnSpec('id', 'Id', true),
            new DataGridColumnSpec('name', 'Name', true),
            new DataGridColumnSpec('status', 'Status', true),
            new DataGridColumnSpec('amount', 'Amount', true),
        ];

        $all = $this->data();

        $needle = mb_strtolower($query->search());
        if ($needle !== '') {
            $all = array_values(array_filter($all, static function (array $item) use ($needle): bool {
                $hay = mb_strtolower((string)($item['id'].' '.$item['name'].' '.$item['status'].' '.$item['amount']));
                return str_contains($hay, $needle);
            }));
        }

        $sortKey = $query->sortKey() ?? 'id';
        $sortDir = $query->sortDir();

        usort($all, static function (array $a, array $b) use ($sortKey, $sortDir): int {
            $va = $a[$sortKey] ?? null;
            $vb = $b[$sortKey] ?? null;

            if ($va === $vb) {
                return 0;
            }

            $cmp = 0;
            if (is_numeric($va) && is_numeric($vb)) {
                $cmp = ((float)$va < (float)$vb) ? -1 : 1;
            } else {
                $cmp = strcmp((string)$va, (string)$vb);
            }

            return ($sortDir === 'desc') ? -$cmp : $cmp;
        });

        $total = count($all);
        $offset = $query->pageIndex() * $query->pageSize();
        $page = array_slice($all, $offset, $query->pageSize());

        $row = [];
        foreach ($page as $item) {
            $row[] = new DataGridRow((string)$item['id'], [
                'id' => $item['id'],
                'name' => $item['name'],
                'status' => $item['status'],
                'amount' => $item['amount'],
            ]);
        }

        return new DataGridResult($column, (int)$row, $query->pageIndex(), $query->pageSize(), $total);
    }

    /**
     * @return list<array{id:int,name:string,status:string,amount:string}>
     */
    private function data(): array
    {
        $out = [];
        for ($i = 1; $i <= 200; $i++) {
            $status = ($i % 2 === 0) ? 'active' : 'inactive';
            $amount = number_format(($i * 3.14159) % 1000, 2, '.', '');
            $out[] = [
                'id' => $i,
                'name' => 'Item '.str_pad((string)$i, 3, '0', STR_PAD_LEFT),
                'status' => $status,
                'amount' => $amount,
            ];
        }

        return $out;
    }
}
