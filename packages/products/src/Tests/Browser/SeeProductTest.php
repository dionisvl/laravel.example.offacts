<?php

namespace AppSmart\Products\Tests\Browser;

use Illuminate\Support\Facades\URL;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Throwable;

class SeeProductTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     * @throws Throwable
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(URL::current() . '/products')
                ->assertSee('Eau Cristaline');
        });
    }
}
