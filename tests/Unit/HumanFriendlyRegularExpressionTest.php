<?php

namespace Tests\Unit;

use App\Services\HumanFriendlyRegularExpression;
use PHPUnit\Framework\TestCase;

class HumanFriendlyRegularExpressionTest extends TestCase
{
    public function test_it_finds_a_string()
    {
        $regex = HumanFriendlyRegularExpression::make()->find('www');
        $this->assertTrue($regex->test('www'));

        $regex = HumanFriendlyRegularExpression::make()->then('www');
        $this->assertTrue($regex->test('www'));
    }

    public function test_it_checks_for_anything()
    {
        $regex = HumanFriendlyRegularExpression::make()->anything('foo');
        $this->assertTrue($regex->test('www'));
    }

    public function test_it_maybe_has_a_value()
    {
        $regex = HumanFriendlyRegularExpression::make()->optional('http');
        $this->assertTrue($regex->test('http'));
        $this->assertTrue($regex->test(''));
    }

    public function test_it_can_chain_method_calls()
    {
        $regex = HumanFriendlyRegularExpression::make()
            ->find('foo')
            ->optional('bar')
            ->then('baz');

        $this->assertTrue($regex->test('foobarbaz'));

        $regex = HumanFriendlyRegularExpression::make()
            ->find('foo')
            ->optional('.')
            ->then('baz');

        $this->assertFalse($regex->test('fooXbaz'));
    }

    public function test_it_can_exclude_values()
    {
        $regex = HumanFriendlyRegularExpression::make()
            ->find('foo')
            ->anythingBut('bar')
            ->then('baz');

        $this->assertTrue($regex->test('foobizbaz'));
        $this->assertFalse($regex->test('foobarbaz'));
    }
}
