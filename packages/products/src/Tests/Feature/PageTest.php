<?php

namespace AppSmart\Products\Tests\Feature;

use Tests\TestCase;

class PageTest extends TestCase
{
    /**
     * product page test
     *
     * @return void
     */
    public function test_product_page_is_well()
    {
        $response = $this->get('/products');

        $response->assertStatus(200);
    }
}
