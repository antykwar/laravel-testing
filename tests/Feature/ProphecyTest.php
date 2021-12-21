<?php

namespace Tests\Feature;

use App\Directives\BladeDirective;
use App\Models\RussianCache;
use Tests\TestCase;

class ProphecyTest extends TestCase
{
    public function test_prophecy_example_one(): void
    {
        $cache = $this->prophesize(RussianCache::class);
        $directive = new BladeDirective($cache->reveal());

        $cache
            ->has('cache-key')
            ->shouldBeCalled();

        $directive->setUp('cache-key');
    }

    public function test_prophecy_example_two(): void
    {
        $cache = $this->prophesize(RussianCache::class);
        $directive = new BladeDirective($cache->reveal());

        $cache
            ->has('stub-cache-key')
            ->shouldBeCalled();

        $directive->setUp($this->getModelStub());
    }

    public function test_prophecy_example_three(): void
    {
        $cache = $this->prophesize(RussianCache::class);
        $directive = new BladeDirective($cache->reveal());

        $item = ['foo', 'bar'];

        $cache
            ->has(md5('foobar'))
            ->shouldBeCalled();

        $directive->setUp($item);
    }

    protected function getModelStub()
    {
        return new class {
            public function getCacheKey()
            {
                return 'stub-cache-key';
            }
        };
    }
}
