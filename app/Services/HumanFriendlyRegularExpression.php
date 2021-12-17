<?php

namespace App\Services;

class HumanFriendlyRegularExpression
{
    protected string $expression = '';

    public static function make()
    {
        return new static();
    }

    public function find($value)
    {
        return $this->add($this->sanitize($value));
    }

    public function then($value)
    {
        return $this->find($value);
    }

    public function anything()
    {
        return $this->add('.*');
    }

    public function optional($value)
    {
        return $this->add('(?:' . $this->sanitize($value) . ')?');
    }

    public function anythingBut($value)
    {
        return $this->add("(?!" . $this->sanitize($value) . ").*?");
    }

    public function test($value)
    {
        return (bool) preg_match($this->getRegex(), $value);
    }

    public function getRegex(): string
    {
        return '/' . $this->expression . '/';
    }

    public function __toString(): string
    {
        return $this->getRegex();
    }

    protected function add($value)
    {
        $this->expression .= $value;

        return $this;
    }

    protected function sanitize($value): string
    {
        return preg_quote($value, '/');
    }
}
