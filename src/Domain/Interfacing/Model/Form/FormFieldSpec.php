<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Domain\Interfacing\Model\Form;

/**
 *
 */

/**
 *
 */
final class FormFieldSpec
{
    /**
     * @param list<array{value:string,label:string}> $option
     */
    public function __construct(
        private string          $id,
        private readonly string $title,
        private string          $type = 'text',
        private readonly bool   $required = false,
        private string          $placeholder = '',
        private readonly array  $option = [],
    ) {
        $this->id = trim($this->id);
        if ($this->id === '') {
            throw new \InvalidArgumentException('FormFieldSpec id must be non-empty.');
        }

        $this->type = $this->normalizeType($this->type);
        $this->placeholder = trim($this->placeholder);
    }

    /**
     * @return string
     */
    public function id(): string { return $this->id; }

    /**
     * @return string
     */
    public function title(): string { return $this->title; }

    /**
     * @return string
     */
    public function type(): string { return $this->type; }

    /**
     * @return bool
     */
    public function required(): bool { return $this->required; }

    /**
     * @return string
     */
    public function placeholder(): string { return $this->placeholder; }

    /** @return list<array{value:string,label:string}> */
    public function option(): array { return $this->option; }

    /**
     * @param string $type
     * @return string
     */
    private function normalizeType(string $type): string
    {
        $type = strtolower(trim($type));
        $allow = ['text', 'email', 'textarea', 'select', 'checkbox', 'number'];
        return in_array($type, $allow, true) ? $type : 'text';
    }
}
