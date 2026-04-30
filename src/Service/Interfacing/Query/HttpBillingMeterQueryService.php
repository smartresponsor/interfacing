<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Query;

use App\Interfacing\Contract\Dto\BillingMeterPage;
use App\Interfacing\Contract\Dto\BillingMeterRow;
use App\Interfacing\ServiceInterface\Interfacing\Query\BillingMeterQueryServiceInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class HttpBillingMeterQueryService implements BillingMeterQueryServiceInterface
{
    public function __construct(
        private HttpClientInterface $client,
        private string $baseUrl,
        private string $path,
    ) {
    }

    /**
     * @throws \JsonException
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function fetchPage(
        string $tenantId,
        int $page,
        int $pageSize,
        ?string $status,
        ?string $periodFromIso,
        ?string $periodToIso,
    ): BillingMeterPage {
        $query = [
            'page' => $page,
            'pageSize' => $pageSize,
        ];

        if (null !== $status && '' !== $status) {
            $query['status'] = $status;
        }
        if (null !== $periodFromIso && '' !== $periodFromIso) {
            $query['periodFrom'] = $periodFromIso;
        }
        if (null !== $periodToIso && '' !== $periodToIso) {
            $query['periodTo'] = $periodToIso;
        }

        $response = $this->client->request('GET', rtrim($this->baseUrl, '/').'/'.ltrim($this->path, '/'), [
            'query' => $query,
            'headers' => [
                'X-SR-Tenant' => $tenantId,
                'Accept' => 'application/json',
            ],
        ]);

        $statusCode = $response->getStatusCode();
        if (200 !== $statusCode) {
            throw new \RuntimeException('Billing API responded with status '.$statusCode);
        }

        $data = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);
        if (!is_array($data)) {
            throw new \RuntimeException('Invalid Billing API response payload.');
        }

        $itemsRaw = $data['items'] ?? null;
        $total = $data['total'] ?? null;
        $pageValue = $data['page'] ?? $page;
        $pageSizeValue = $data['pageSize'] ?? $pageSize;

        if (!is_array($itemsRaw)) {
            throw new \RuntimeException('Billing API items field must be array.');
        }

        $items = [];
        foreach ($itemsRaw as $row) {
            if (!is_array($row)) {
                continue;
            }
            $id = (string) ($row['id'] ?? '');
            $statusValue = (string) ($row['status'] ?? '');
            $amountValue = (float) ($row['amount'] ?? 0.0);
            $fromIso = (string) ($row['periodFrom'] ?? '');
            $toIso = (string) ($row['periodTo'] ?? '');

            if ('' === $id || '' === $fromIso || '' === $toIso) {
                continue;
            }

            $items[] = new BillingMeterRow(
                $id,
                $statusValue,
                $amountValue,
                $fromIso,
                $toIso,
            );
        }

        return new BillingMeterPage(
            $items,
            is_int($total) ? $total : count($items),
            (int) $pageValue,
            (int) $pageSizeValue,
        );
    }
}
