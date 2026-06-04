<?php

declare(strict_types=1);

# Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp

namespace App\Interfacing\Mapper\View;

use App\Interfacing\Contract\Error\InterfaceScreenForbidden;
use App\Interfacing\Contract\Error\InterfaceScreenNotFound;
use App\Interfacing\Contract\Error\InterfaceUiErrorCode;
use App\Interfacing\MapperInterface\View\InterfaceUiErrorMapperInterface;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

final class InterfaceUiErrorMapper implements InterfaceUiErrorMapperInterface
{
    public function map(\Throwable $e, ?string $traceId = null): array
    {
        if ($e instanceof InterfaceScreenNotFound) {
            return $this->out(404, InterfaceUiErrorCode::NOT_FOUND, 'Not found', $e->getMessage(), $traceId);
        }
        if ($e instanceof InterfaceScreenForbidden) {
            return $this->out(403, InterfaceUiErrorCode::FORBIDDEN, 'Forbidden', $e->getMessage(), $traceId);
        }
        if ($e instanceof HttpExceptionInterface) {
            $status = $e->getStatusCode();
            if (422 === $status) {
                return $this->out(422, InterfaceUiErrorCode::VALIDATION, 'Validation failed', $e->getMessage(), $traceId);
            }
            if (503 === $status) {
                return $this->out(503, InterfaceUiErrorCode::UNAVAILABLE, 'Service unavailable', $e->getMessage(), $traceId);
            }
            if (504 === $status) {
                return $this->out(504, InterfaceUiErrorCode::TIMEOUT, 'Timeout', $e->getMessage(), $traceId);
            }
            if (404 === $status) {
                return $this->out(404, InterfaceUiErrorCode::NOT_FOUND, 'Not found', $e->getMessage(), $traceId);
            }
            if (403 === $status) {
                return $this->out(403, InterfaceUiErrorCode::FORBIDDEN, 'Forbidden', $e->getMessage(), $traceId);
            }
        }

        return $this->out(500, InterfaceUiErrorCode::UNEXPECTED, 'Unexpected error', 'Unexpected failure', $traceId);
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
