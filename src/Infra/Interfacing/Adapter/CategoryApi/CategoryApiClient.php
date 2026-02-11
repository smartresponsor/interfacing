<?php
declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Infra\Interfacing\Adapter\CategoryApi;

use App\Domain\Interfacing\Model\CategoryItemView;
use App\Infra\Interfacing\Config\CategoryApiRouteMap;
use App\Infra\Interfacing\Config\InterfacingConfig;
use App\ServiceInterface\Interfacing\CategoryApiClientInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 *
 */

/**
 *
 */
final class CategoryApiClient implements CategoryApiClientInterface
{
    /**
     * @param \Symfony\Contracts\HttpClient\HttpClientInterface $httpClient
     * @param \App\Infra\Interfacing\Config\InterfacingConfig $config
     * @param \App\Infra\Interfacing\Config\CategoryApiRouteMap $route
     */
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly InterfacingConfig   $config,
        private readonly CategoryApiRouteMap $route
    ) {}

    public function list(string $query, ?string $cursor, int $limit): array
    {
        $this->assertConfigured();
        $url = $this->config->categoryApiBaseUrl().$this->route->listPath();

        $res = $this->httpClient->request('GET', $url, [
            'query' => array_filter(['q' => $query, 'cursor' => $cursor, 'limit' => $limit], static fn($v): bool => $v !== null && $v !== ''),
            'timeout' => $this->config->categoryApiTimeoutMs() / 1000.0,
        ]);

        $data = $res->toArray(false);
        if (!is_array($data)) {
            throw new \RuntimeException('Category API list returned invalid payload.');
        }

        $item = [];
        foreach (($data['item'] ?? []) as $row) {
            if (!is_array($row)) { continue; }
            $item[] = new CategoryItemView(
                (string)($row['id'] ?? ''),
                (string)($row['slug'] ?? ''),
                (string)($row['name'] ?? ''),
                (string)($row['locale'] ?? 'en'),
                (string)($row['status'] ?? 'active'),
            );
        }

        return ['item' => $item, 'nextCursor' => isset($data['nextCursor']) ? (string)$data['nextCursor'] : null];
    }

    /**
     * @param string $id
     * @return array|mixed[]
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function read(string $id): array
    {
        $this->assertConfigured();
        $url = $this->config->categoryApiBaseUrl().$this->route->readPath($id);

        $res = $this->httpClient->request('GET', $url, [
            'timeout' => $this->config->categoryApiTimeoutMs() / 1000.0,
        ]);

        $data = $res->toArray(false);
        if (!is_array($data)) {
            throw new \RuntimeException('Category API read returned invalid payload.');
        }
        return $data;
    }

    /**
     * @param string $id
     * @param array $payload
     * @return array
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function save(string $id, array $payload): array
    {
        $this->assertConfigured();
        $url = $this->config->categoryApiBaseUrl().$this->route->savePath($id);

        $res = $this->httpClient->request('PUT', $url, [
            'json' => $payload,
            'timeout' => $this->config->categoryApiTimeoutMs() / 1000.0,
        ]);

        $data = $res->toArray(false);
        if (!is_array($data)) {
            throw new \RuntimeException('Category API save returned invalid payload.');
        }
        return $data;
    }

    /**
     * @return void
     */
    private function assertConfigured(): void
    {
        if ($this->config->categoryApiBaseUrl() === '') {
            throw new \RuntimeException('INTERFACING_CATEGORY_API_BASE_URL is not configured.');
        }
    }
}
