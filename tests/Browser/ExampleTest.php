<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\Browser\Pages\ClickedPage;
use Tests\Browser\Pages\HomePage;
use Tests\DuskTestCase;
use Throwable;

class ExampleTest extends DuskTestCase
{
    /**
     * @return void
     * @throws Throwable
     */
    public function testClickMeLink(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new HomePage)
                    ->assertSeeLink('Click Me')
                    ->click('@click-me-link')
                    ->on(new ClickedPage)
                    ->assertSee('We clicked that link!');
        });
    }
}
