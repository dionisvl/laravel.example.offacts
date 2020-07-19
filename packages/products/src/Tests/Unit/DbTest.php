<?php

namespace AppSmart\Products\Tests\Unit;

use AppSmart\Products\Models\Product;
use Tests\TestCase;

class DbTest extends TestCase
{
    /**
     * database create product test
     */
    public function testCreateProduct()
    {
        $this->post(route('productStore'), [
            Product::ATTR_ID => '123123321321',
            Product::ATTR_NAME => 'My test product name',
            Product::ATTR_IMAGE => 'https://static.openfoodfacts.org/images/products/327/408/000/5003/front_en.574.400.jpg',
            Product::ATTR_CATEGORY => 'my test category',
        ]);

        $this->assertDatabaseHas('products', [Product::ATTR_NAME => 'My test product name']);
        $this->assertDatabaseMissing('products', [Product::ATTR_NAME => 'Not existing product']);
    }

}
