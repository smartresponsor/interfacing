<?php

declare(strict_types=1);

namespace App\Tests\Interfacing\Query;

use App\Contract\Dto\OrderSummaryPage;
use App\Contract\Dto\OrderSummaryRow;
use App\Service\Interfacing\Query\HttpOrderSummaryQueryService;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\ResponseStreamInterface;

final class HttpOrderSummaryQueryServiceTest extends TestCase
{
    /**
     * @throws \JsonException
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function testFetchPageBuildsQueryAndParsesResponse(): void
    {
        $payload = [
            'items' => [
                [
                    'id' => 'ord_1',
                    'status' => 'paid',
                    'createdAt' => '2025-01-01T10:00:00Z',
                    'totalGross' => 199.99,
                    'currency' => 'USD',
                    'customerEmail' => 'buyer@example.com',
                ],
            ],
            'total' => 1,
            'page' => 3,
            'pageSize' => 20,
        ];

        $client = new FakeOrderHttpClient(200, $payload);
        $service = new HttpOrderSummaryQueryService(
            $client,
            'https://order.example',
            '/api/admin/order',
        );

        $page = $service->fetchPage(
            'tenant-2',
            3,
            20,
            'paid',
            '2025-01-01',
            '2025-01-31',
        );

        self::assertInstanceOf(OrderSummaryPage::class, $page);
        self::assertSame(1, $page->total);
        self::assertSame(3, $page->page);
        self::assertSame(20, $page->pageSize);
        self::assertCount(1, $page->items);
        self::assertInstanceOf(OrderSummaryRow::class, $page->items[0]);
        self::assertSame('ord_1', $page->items[0]->id);
        self::assertSame('USD', $page->items[0]->currencyCode);

        self::assertSame('GET', $client->lastMethod);
        self::assertSame('https://order.example/api/admin/order', $client->lastUrl);
        self::assertSame('tenant-2', $client->lastOptions['headers']['X-SR-Tenant'] ?? null);

        $query = $client->lastOptions['query'] ?? null;
        self::assertIsArray($query);
        self::assertSame(3, $query['page']);
        self::assertSame(20, $query['pageSize']);
        self::assertSame('paid', $query['status']);
        self::assertSame('2025-01-01', $query['createdFrom']);
        self::assertSame('2025-01-31', $query['createdTo']);
    }

    /**
     * @throws \JsonException
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function testNon200ResponseThrows(): void
    {
        $client = new FakeOrderHttpClient(503, ['error' => 'maintenance']);
        $service = new HttpOrderSummaryQueryService(
            $client,
            'https://order.example',
            '/api/admin/order',
        );

        $this->expectException(\RuntimeException::class);

        $service->fetchPage(
            'tenant-2',
            1,
            25,
            null,
            null,
            null,
        );
    }
}

/**
 * Simple in-memory HttpClient for Order tests.
 */
final class FakeOrderHttpClient implements HttpClientInterface
{
    public ?string $lastMethod = null;
    public ?string $lastUrl = null;
    /** @var array<string,mixed>|null */
    public ?array $lastOptions = null;

    private int $statusCode;
    /** @var array<string,mixed> */
    private array $payload;

    /**
     * @param array<string,mixed> $payload
     */
    public function __construct(int $statusCode, array $payload)
    {
        $this->statusCode = $statusCode;
        $this->payload = $payload;
    }

    /**
     * @param array<string,mixed> $options
     */
    public function request(string $method, string $url, array $options = []): ResponseInterface
    {
        $this->lastMethod = $method;
        $this->lastUrl = $url;
        $this->lastOptions = $options;

        return new FakeOrderResponse($this->statusCode, $this->payload);
    }

    public function stream($responses, ?float $timeout = null): ResponseStreamInterface
    {
        throw new \RuntimeException('Not implemented for FakeOrderHttpClient.');
    }

    /**
     * @return $this
     */
    public function withOptions(array $options): self
    {
        // Options are not used in this simple fake.
        return $this;
    }
}
final class FakeOrderResponse implements ResponseInterface
{
    /** @var array<string,mixed> */
    private array $payload;
    private int $statusCode;

    /**
     * @param array<string,mixed> $payload
     */
    public function __construct(int $statusCode, array $payload)
    {
        $this->statusCode = $statusCode;
        $this->payload = $payload;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return array|string[][]
     */
    public function getHeaders(bool $throw = true): array
    {
        return [];
    }

    /**
     * @throws \JsonException
     */
    public function getContent(bool $throw = true): string
    {
        return json_encode($this->payload, JSON_THROW_ON_ERROR);
    }

    /**
     * @return mixed[]
     */
    public function toArray(bool $throw = true): array
    {
        return $this->payload;
    }

    public function cancel(): void
    {
        // Nothing to cancel in this fake.
    }

    public function getInfo(?string $type = null): mixed
    {
        return null;
    }
}
