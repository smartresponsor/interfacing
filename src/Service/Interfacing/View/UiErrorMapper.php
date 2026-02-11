<?php
declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace SmartResponsor\Interfacing\Service\Interfacing\View;

use SmartResponsor\Interfacing\Domain\Interfacing\Error\ScreenForbidden;
use SmartResponsor\Interfacing\Domain\Interfacing\Error\ScreenNotFound;
use SmartResponsor\Interfacing\Domain\Interfacing\Error\UiErrorCode;
use SmartResponsor\Interfacing\ServiceInterface\Interfacing\View\UiErrorMapperInterface;
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
            if ($status === 422) {
                return $this->out(422, UiErrorCode::VALIDATION, 'Validation failed', $e->getMessage(), $traceId);
            }
            if ($status === 503) {
                return $this->out(503, UiErrorCode::UNAVAILABLE, 'Service unavailable', $e->getMessage(), $traceId);
            }
            if ($status === 504) {
                return $this->out(504, UiErrorCode::TIMEOUT, 'Timeout', $e->getMessage(), $traceId);
            }
            if ($status === 404) {
                return $this->out(404, UiErrorCode::NOT_FOUND, 'Not found', $e->getMessage(), $traceId);
            }
            if ($status === 403) {
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
