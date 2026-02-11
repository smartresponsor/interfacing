<?php
    declare(strict_types=1);

    /* Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp */

    namespace App\Service\Interfacing\Builder;

    use App\Domain\Interfacing\Spec\MetricSpec;
use App\ServiceInterface\Interfacing\Builder\MetricSpecBuilderInterface;

    /**
     *
     */

    /**
     *
     */
    final class MetricSpecBuilder implements MetricSpecBuilderInterface
{
    private ?string $hint = null;

    /**
     * @param string $id
     * @param string $title
     * @param string $value
     */
    private function __construct(
        private readonly string $id,
        private readonly string $title,
        private string $value,
    ) {
    }

    /**
     * @param string $id
     * @param string $title
     * @param string $value
     * @return self
     */
    public static function create(string $id, string $title, string $value): self
    {
        return new self($id, $title, $value);
    }

    /**
     * @param string|null $hint
     * @return $this
     */
    public function hint(?string $hint): self
    {
        $this->hint = $hint;
        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function value(string $value): self
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return \App\Domain\Interfacing\Spec\MetricSpec
     */
    public function build(): MetricSpec
    {
        return new MetricSpec($this->id, $this->title, $this->value, $this->hint);
    }
}

