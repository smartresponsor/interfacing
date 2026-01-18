<?php
declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace SmartResponsor\Interfacing\Domain\Interfacing\Model\Form;

final class FormFieldSpec
{
    /**
     * @param list<array{value:string,label:string}> $option
     */
    public function __construct(
        private string $id,
        private string $title,
        private string $type = 'text',
        private bool $required = false,
        private string $placeholder = '',
        private array $option = [],
    ) {
        $this->id = trim($this->id);
        if ($this->id === '') {
            throw new \InvalidArgumentException('FormFieldSpec id must be non-empty.');
        }

        $this->type = $this->normalizeType($this->type);
        $this->placeholder = trim($this->placeholder);
    }

    public function id(): string { return $this->id; }
    public function title(): string { return $this->title; }
    public function type(): string { return $this->type; }
    public function required(): bool { return $this->required; }
    public function placeholder(): string { return $this->placeholder; }

    /** @return list<array{value:string,label:string}> */
    public function option(): array { return $this->option; }

    private function normalizeType(string $type): string
    {
        $type = strtolower(trim($type));
        $allow = ['text', 'email', 'textarea', 'select', 'checkbox', 'number'];
        return in_array($type, $allow, true) ? $type : 'text';
    }
}
