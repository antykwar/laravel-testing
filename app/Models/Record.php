<?php

namespace App\Models;

class Record
{

    public function __construct(protected string $name, protected ?int $price = null) {}

    public function name(): string
    {
        return $this->name;
    }

    public function price(): float
    {
        return $this->price;
    }
}
