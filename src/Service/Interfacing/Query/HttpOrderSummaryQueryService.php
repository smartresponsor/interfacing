Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
<?php
declare(strict_types=1);

namespace App\Service\Interfacing\Query;

use App\Domain\Interfacing\Query\OrderSummaryPage;
use App\Domain\Interfacing\Query\OrderSummaryRow;
use App\ServiceInterface\Interfacing\Query\OrderSummaryQueryServiceInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class HttpOrderSummaryQueryService implements OrderSummaryQueryServiceInterface
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly string $baseUrl,
        private readonly string $path,
    ) {}

    public function fetchPage(
        string $tenantId,
        int $page,
        int $pageSize,
        ?string $status,
        ?string $createdFromIso,
        ?string $createdToIso,
    ): OrderSummaryPage {
        $query = [
            'page' => $page,
            'pageSize' => $pageSize,
        ];

        if ($status !== null && $status !== '') {
            $query['status'] = $status;
        }
        if ($createdFromIso !== null && $createdFromIso !== '') {
            $query['createdFrom'] = $createdFromIso;
        }
        if ($createdToIso !== null && $createdToIso !== '') {
            $query['createdTo'] = $createdToIso;
        }

        $response = $this->client->request('GET', rtrim($this->baseUrl, '/') . '/' . ltrim($this->path, '/'), [
            'query' => $query,
            'headers' => [
                'X-SR-Tenant' => $tenantId,
                'Accept' => 'application/json',
            ],
        ]);

        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            throw new \RuntimeException('Order API responded with status ' . $statusCode);
        }

        $data = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);
        if (!is_array($data)) {
            throw new \RuntimeException('Invalid Order API response payload.');
        }

        $itemsRaw = $data['items'] ?? null;
        $total = $data['total'] ?? null;
        $pageValue = $data['page'] ?? $page;
        $pageSizeValue = $data['pageSize'] ?? $pageSize;

        if (!is_array($itemsRaw)) {
            throw new \RuntimeException('Order API items field must be array.');
        }

        $items = [];
        foreach ($itemsRaw as $row) {
            if (!is_array($row)) {
                continue;
            }
            $id = (string) ($row['id'] ?? '');
            $statusValue = (string) ($row['status'] ?? '');
            $createdIso = (string) ($row['createdAt'] ?? '');
            $totalGrossValue = (float) ($row['totalGross'] ?? 0.0);
            $currency = (string) ($row['currency'] ?? '');
            $email = $row['customerEmail'] ?? null;
            if ($email !== null) {
                $email = (string) $email;
            }

            if ($id === '' || $createdIso === '' || $currency === '') {
                continue;
            }

            $items[] = new OrderSummaryRow(
                $id,
                $statusValue,
                $createdIso,
                $totalGrossValue,
                $currency,
                $email,
            );
        }

        return new OrderSummaryPage(
            $items,
            is_int($total) ? $total : count($items),
            (int) $pageValue,
            (int) $pageSizeValue,
        );
    }
}
