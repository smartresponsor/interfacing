<?php

declare(strict_types=1);

namespace App\Interfacing\Tests\Interfacing\Query;

use App\Interfacing\Contract\Dto\BillingMeterPage;
use App\Interfacing\Contract\Dto\BillingMeterRow;
use App\Interfacing\Service\Interfacing\Query\HttpBillingMeterQueryService;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\ResponseStreamInterface;

final class HttpBillingMeterQueryServiceTest extends TestCase
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
                    'id' => 'mtr_1',
                    'status' => 'active',
                    'amount' => 123.45,
                    'periodFrom' => '2025-01-01',
                    'periodTo' => '2025-01-31',
                ],
            ],
            'total' => 1,
            'page' => 2,
            'pageSize' => 50,
        ];

        $client = new FakeHttpClient(200, $payload);
        $service = new HttpBillingMeterQueryService(
            $client,
            'https://billing.example',
            '/api/admin/meter',
        );

        $page = $service->fetchPage(
            'tenant-1',
            2,
            50,
            'active',
            '2025-01-01',
            '2025-01-31',
        );

        self::assertInstanceOf(BillingMeterPage::class, $page);
        self::assertSame(1, $page->total);
        self::assertSame(2, $page->page);
        self::assertSame(50, $page->pageSize);
        self::assertCount(1, $page->items);
        self::assertInstanceOf(BillingMeterRow::class, $page->items[0]);
        self::assertSame('mtr_1', $page->items[0]->id);

        self::assertSame('GET', $client->lastMethod);
        self::assertSame('https://billing.example/api/admin/meter', $client->lastUrl);
        self::assertSame('tenant-1', $client->lastOptions['headers']['X-SR-Tenant'] ?? null);

        $query = $client->lastOptions['query'] ?? null;
        self::assertIsArray($query);
        self::assertSame(2, $query['page']);
        self::assertSame(50, $query['pageSize']);
        self::assertSame('active', $query['status']);
        self::assertSame('2025-01-01', $query['periodFrom']);
        self::assertSame('2025-01-31', $query['periodTo']);
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
        $client = new FakeHttpClient(500, ['error' => 'fail']);
        $service = new HttpBillingMeterQueryService(
            $client,
            'https://billing.example',
            '/api/admin/meter',
        );

        $this->expectException(\RuntimeException::class);

        $service->fetchPage(
            'tenant-1',
            1,
            25,
            null,
            null,
            null,
        );
    }
}

/**
 * Simple in-memory HttpClient for tests.
 */
final class FakeHttpClient implements HttpClientInterface
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

        return new FakeResponse($this->statusCode, $this->payload);
    }

    public function stream($responses, ?float $timeout = null): ResponseStreamInterface
    {
        throw new \RuntimeException('Not implemented for FakeHttpClient.');
    }

    public function withOptions(array $options): static
    {
        // Options are not used in this simple fake.
        return $this;
    }
}
final class FakeResponse implements ResponseInterface
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
