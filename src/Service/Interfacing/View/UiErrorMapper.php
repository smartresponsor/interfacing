<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\Service\Interfacing\View;

use App\Interfacing\Contract\Error\ScreenForbidden;
use App\Interfacing\Contract\Error\ScreenNotFound;
use App\Interfacing\Contract\Error\UiErrorCode;
use App\Interfacing\ServiceInterface\Interfacing\View\UiErrorMapperInterface;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

final class UiErrorMapper implements UiErrorMapperInterface
{
    public function map(\Throwable $e, ?string $traceId = null): array
    {
        if ($e instanceof ScreenNotFound) {
            return $this->out(404, UiErrorCode::NOT_FOUND, 'Not found', $e->getMessage(), $traceId);
        }
        if ($e instanceof ScreenForbidden) {
            return $this->out(403, UiErrorCode::FORBIDDEN, 'Forbidden', $e->getMessage(), $traceId);
        }
        if ($e instanceof HttpExceptionInterface) {
            $status = $e->getStatusCode();
            if (422 === $status) {
                return $this->out(422, UiErrorCode::VALIDATION, 'Validation failed', $e->getMessage(), $traceId);
            }
            if (503 === $status) {
                return $this->out(503, UiErrorCode::UNAVAILABLE, 'Service unavailable', $e->getMessage(), $traceId);
            }
            if (504 === $status) {
                return $this->out(504, UiErrorCode::TIMEOUT, 'Timeout', $e->getMessage(), $traceId);
            }
            if (404 === $status) {
                return $this->out(404, UiErrorCode::NOT_FOUND, 'Not found', $e->getMessage(), $traceId);
            }
            if (403 === $status) {
                return $this->out(403, UiErrorCode::FORBIDDEN, 'Forbidden', $e->getMessage(), $traceId);
            }
        }

        return $this->out(500, UiErrorCode::UNEXPECTED, 'Unexpected error', 'Unexpected failure', $traceId);
    }

    private function out(int $status, string $code, string $title, string $detail, ?string $traceId): array
    {
        return [
            'status' => $status,
            'code' => $code,
            'title' => $title,
            'detail' => $detail,
            'traceId' => $traceId,
        ];
    }
}
