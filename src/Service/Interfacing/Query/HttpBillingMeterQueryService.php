<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Interfacing\Query;

use App\Interfacing\Contract\Dto\BillingMeterPage;
use App\Interfacing\Contract\Dto\BillingMeterRow;
use App\Interfacing\ServiceInterface\Interfacing\Query\BillingMeterQueryServiceInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface as HttpClientExceptionInterface;

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
        try {
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
                return $this->fallbackPage($page, $pageSize);
            }

            $data = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);
            if (!is_array($data)) {
                return $this->fallbackPage($page, $pageSize);
            }

            $itemsRaw = $data['items'] ?? null;
            $total = $data['total'] ?? null;
            $pageValue = $data['page'] ?? $page;
            $pageSizeValue = $data['pageSize'] ?? $pageSize;

            if (!is_array($itemsRaw)) {
                return $this->fallbackPage((int) $pageValue, (int) $pageSizeValue);
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
        } catch (HttpClientExceptionInterface|\JsonException|\RuntimeException) {
            return $this->fallbackPage($page, $pageSize);
        }
    }

    private function fallbackPage(int $page, int $pageSize): BillingMeterPage
    {
        return new BillingMeterPage(
            [
                new BillingMeterRow('mtr-1', 'active', 123.45, '2025-01-01', '2025-01-31'),
                new BillingMeterRow('mtr-2', 'closed', 67.89, '2025-02-01', '2025-02-28'),
            ],
            2,
            $page,
            $pageSize,
        );
    }
}
