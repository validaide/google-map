<?php


namespace Ivory\GoogleMap\Helper\Builder;

use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

/**
 * @author Amshu Kanth <amshu.kanth.bugudi@validaides.com>
 */
class JsonBuilder
{
    private readonly PropertyAccessorInterface $accessor;

    private array $values;

    private array $escapes;

    private int $jsonEncodeOptions;

    public function __construct(PropertyAccessorInterface $propertyAccessor = null)
    {
        $this->accessor = $propertyAccessor ?: new PropertyAccessor();

        $this->reset();
    }

    public function getJsonEncodeOptions(): int
    {
        return $this->jsonEncodeOptions;
    }

    public function setJsonEncodeOptions(int $jsonEncodeOptions): self
    {
        $this->jsonEncodeOptions = $jsonEncodeOptions;

        return $this;
    }

    public function hasValues(): bool
    {
        return !empty($this->values);
    }

    /**
     * @return mixed[]
     */
    public function getValues(): array
    {
        return $this->values;
    }

    public function setValues(array $values, ?string $pathPrefix = null): self
    {
        foreach ($values as $key => $value) {
            $path = sprintf('%s[%s]', $pathPrefix, $key);

            if (is_array($value) && !empty($value)) {
                $this->setValues($value, $path);
            } else {
                $this->setValue($path, $value);
            }
        }

        return $this;
    }

    public function setValue(string $path, mixed $value, bool $escapeValue = true): self
    {
        if (!$escapeValue) {
            $placeholder = uniqid('ivory', true);
            $this->escapes[sprintf('"%s"', $placeholder)] = $value;

            $value = $placeholder;
        }

        $this->values[$path] = $value;

        return $this;
    }

    public function removeValue(string $path): self
    {
        unset($this->values[$path]);
        unset($this->escapes[$path]);

        return $this;
    }

    public function reset(): self
    {
        $this->values = [];
        $this->escapes = [];
        $this->jsonEncodeOptions = 0;

        return $this;
    }

    public function build(): string
    {
        $json = [];

        foreach ($this->values as $path => $value) {
            $this->accessor->setValue($json, $path, $value);
        }

        return str_replace(
            array_keys($this->escapes),
            array_values($this->escapes),
            json_encode($json, $this->jsonEncodeOptions)
        );
    }
}