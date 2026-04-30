<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Query;

use App\Interfacing\Contract\Dto\OrderSummaryPage;
use App\Interfacing\Contract\Dto\OrderSummaryRow;
use App\Interfacing\ServiceInterface\Interfacing\Query\OrderSummaryQueryServiceInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class HttpOrderSummaryQueryService implements OrderSummaryQueryServiceInterface
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
        ?string $createdFromIso,
        ?string $createdToIso,
    ): OrderSummaryPage {
        $query = [
            'page' => $page,
            'pageSize' => $pageSize,
        ];

        if (null !== $status && '' !== $status) {
            $query['status'] = $status;
        }
        if (null !== $createdFromIso && '' !== $createdFromIso) {
            $query['createdFrom'] = $createdFromIso;
        }
        if (null !== $createdToIso && '' !== $createdToIso) {
            $query['createdTo'] = $createdToIso;
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
            throw new \RuntimeException('Order API responded with status '.$statusCode);
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
            if (null !== $email) {
                $email = (string) $email;
            }

            if ('' === $id || '' === $createdIso || '' === $currency) {
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
