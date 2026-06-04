<?php

declare(strict_types=1);

namespace App\Interfacing\Contract\Action;

use App\Interfacing\Contract\Ui\InterfaceUiError;
use App\Interfacing\Contract\Ui\InterfaceUiErrorBag;
use App\Interfacing\Contract\Ui\InterfaceUiErrorInterface;
use App\Interfacing\Contract\Ui\InterfaceUiMessage;
use App\Interfacing\Contract\Ui\InterfaceUiMessageInterface;

final class InterfaceActionResult implements InterfaceActionResultInterface
{
    public const TYPE_OK = 'ok';
    public const TYPE_FAIL = 'fail';
    public const TYPE_REDIRECT = 'redirect';
    public const TYPE_VALIDATION_ERROR = 'validation_error';
    public const TYPE_DOMAIN_ERROR = 'domain_error';
    public const TYPE_RELOAD = 'reload';

    /** @var list<InterfaceUiErrorInterface> */
    private array $error = [];

    /** @var list<InterfaceUiMessageInterface> */
    private array $message = [];

    /** @param array<string, mixed> $data */
    private function __construct(
        private readonly string $type,
        private readonly array $data = [],
    ) {
    }

    /** @param array<string, mixed> $data */
    public static function ok(array $data = []): self
    {
        return new self(self::TYPE_OK, $data);
    }

    /**
     * @param list<InterfaceUiErrorInterface>   $error
     * @param list<InterfaceUiMessageInterface> $message
     */
    public static function fail(array $error = [], array $message = []): self
    {
        $result = new self(self::TYPE_FAIL);
        $result->error = array_values($error);
        $result->message = array_values($message);

        return $result;
    }

    /** @param list<InterfaceUiMessageInterface> $message */
    public static function validationError(InterfaceUiErrorBag $errorBag, array $message = []): self
    {
        $result = new self(self::TYPE_VALIDATION_ERROR, ['bag' => $errorBag->toArray()]);
        $errors = [];
        foreach ($errorBag->global() as $error) {
            $errors[] = $error;
        }
        foreach ($errorBag->field() as $fieldErrors) {
            foreach ($fieldErrors as $error) {
                $errors[] = $error;
            }
        }
        $result->error = $errors;
        $result->message = array_values($message);

        return $result;
    }

    public static function domainError(string $code, string $message): self
    {
        $result = new self(self::TYPE_DOMAIN_ERROR, ['message' => $message, 'code' => $code]);
        $result->error = [new InterfaceUiError('action', null, $message, $code)];
        $result->message = [new InterfaceUiMessage('error', $message, $code)];

        return $result;
    }

    public static function redirect(string $url): self
    {
        $url = trim($url);
        if ('' === $url || strlen($url) > 2000) {
            throw new \InvalidArgumentException('Invalid redirect url.');
        }

        return new self(self::TYPE_REDIRECT, ['url' => $url]);
    }

    public static function reload(): self
    {
        return new self(self::TYPE_RELOAD);
    }

    public function type(): string
    {
        return $this->type;
    }

    public function kind(): string
    {
        return $this->type;
    }

    /** @return array<string, mixed> */
    public function data(): array
    {
        return $this->data;
    }

    /** @return array<string, mixed> */
    public function payload(): array
    {
        return $this->data;
    }

    /** @return list<InterfaceUiErrorInterface> */
    public function error(): array
    {
        return $this->error;
    }

    /** @return list<InterfaceUiMessageInterface> */
    public function message(): array
    {
        return $this->message;
    }

    /** @return list<InterfaceUiMessageInterface> */
    public function messageList(): array
    {
        return $this->message;
    }

    public function isOk(): bool
    {
        return self::TYPE_OK === $this->type;
    }
}
