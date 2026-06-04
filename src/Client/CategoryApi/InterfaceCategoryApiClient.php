<?php

declare(strict_types=1);

// Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\Client\CategoryApi;

use App\Interfacing\ClientInterface\CategoryApi\InterfaceCategoryApiClientInterface;
use App\Interfacing\Configuration\InterfaceCategoryApiRouteMap;
use App\Interfacing\Configuration\InterfaceConfig;
use App\Interfacing\Contract\Dto\InterfaceCategoryItemView;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class InterfaceCategoryApiClient implements InterfaceCategoryApiClientInterface
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly InterfaceConfig $config,
        private readonly InterfaceCategoryApiRouteMap $route,
    ) {
    }

    public function list(string $query, ?string $cursor, int $limit): array
    {
        $this->assertConfigured();
        $url = $this->config->categoryApiBaseUrl().$this->route->listPath();

        $res = $this->httpClient->request('GET', $url, [
            'query' => array_filter(['q' => $query, 'cursor' => $cursor, 'limit' => $limit], static fn ($v): bool => null !== $v && '' !== $v),
            'timeout' => $this->config->categoryApiTimeoutMs() / 1000.0,
        ]);

        $data = $res->toArray(false);
        if (!is_array($data)) {
            throw new \RuntimeException('Category API list returned invalid payload.');
        }

        $item = [];
        foreach (($data['item'] ?? []) as $row) {
            if (!is_array($row)) {
                continue;
            }
            $item[] = new InterfaceCategoryItemView(
                (string) ($row['id'] ?? ''),
                (string) ($row['slug'] ?? ''),
                (string) ($row['name'] ?? ''),
                (string) ($row['locale'] ?? 'en'),
                (string) ($row['status'] ?? 'active'),
            );
        }

        return ['item' => $item, 'nextCursor' => isset($data['nextCursor']) ? (string) $data['nextCursor'] : null];
    }

    /**
     * @return array|mixed[]
     *
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

    private function assertConfigured(): void
    {
        if ('' === $this->config->categoryApiBaseUrl()) {
            throw new \RuntimeException('INTERFACING_CATEGORY_API_BASE_URL is not configured.');
        }
    }
}
