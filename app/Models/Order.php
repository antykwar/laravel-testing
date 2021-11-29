<?php

namespace App\Models;

class Order
{
    protected array $records = [];

    public function add(Record $record): void
    {
        $this->records[] = $record;
    }

    public function records(): array
    {
        return $this->records;
    }

    public function total(): int
    {
        return collect($this->records)->sum(function($record){return $record->price();});
    }
}
