<?php

namespace Tests\Unit\Models;

use App\Models\Order;
use App\Models\Record;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    protected Order $order;

    protected function setUp(): void
    {
        parent::setUp();

        $this->order = new Order;

        $record  = new Record('Record 1', 150);
        $record2 = new Record('Record 2', 300);

        $this->order->add($record);
        $this->order->add($record2);
    }

    public function test_order_consists_of_products():void
    {
        $this->assertCount(2, $this->order->records());
    }

    public function test_order_can_find_total_cost_of_all_records(): void
    {
        $this->assertEquals(450, $this->order->total());
    }
}
