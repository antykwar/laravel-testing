<?php

namespace Tests\Unit\Models;

use App\Models\Record;
use JetBrains\PhpStorm\Pure;
use PHPUnit\Framework\TestCase;


class RecordTest extends TestCase
{
    protected Record $record;

    public function setUp(): void
    {
        parent::setUp();
        $this->record = new Record(name: 'A cup of tea', price: 300);
    }

    public function test_record_has_name(): void
    {
        $this->assertEquals('A cup of tea', $this->record->name());
    }

    public function test_record_has_price(): void
    {
        $this->assertEquals(300, $this->record->price());
    }
}
