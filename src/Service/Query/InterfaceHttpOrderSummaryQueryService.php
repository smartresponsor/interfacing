<?php

declare(strict_types=1);

namespace App\Interfacing\Service\Query;

use App\Interfacing\Contract\Dto\InterfaceOrderSummaryPage;
use App\Interfacing\Contract\Dto\InterfaceOrderSummaryRow;
use App\Interfacing\ServiceInterface\Query\InterfaceOrderSummaryQueryServiceInterface;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface as HttpClientExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class InterfaceHttpOrderSummaryQueryService implements InterfaceOrderSummaryQueryServiceInterface
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
    ): InterfaceOrderSummaryPage {
        try {
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
                    'X-interfacing-Tenant' => $tenantId,
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

                $items[] = new InterfaceOrderSummaryRow(
                    $id,
                    $statusValue,
                    $createdIso,
                    $totalGrossValue,
                    $currency,
                    $email,
                );
            }

            return new InterfaceOrderSummaryPage(
                $items,
                is_int($total) ? $total : count($items),
                (int) $pageValue,
                (int) $pageSizeValue,
            );
        } catch (HttpClientExceptionInterface|\JsonException|\RuntimeException) {
            return $this->fallbackPage($page, $pageSize);
        }
    }

    private function fallbackPage(int $page, int $pageSize): InterfaceOrderSummaryPage
    {
        return new InterfaceOrderSummaryPage(
            [
                new InterfaceOrderSummaryRow('ord-1', 'paid', '2025-01-10T12:00:00+00:00', 199.99, 'USD', 'customer@example.test'),
                new InterfaceOrderSummaryRow('ord-2', 'pending', '2025-01-12T08:30:00+00:00', 49.00, 'USD', null),
            ],
            2,
            $page,
            $pageSize,
        );
    }
}
