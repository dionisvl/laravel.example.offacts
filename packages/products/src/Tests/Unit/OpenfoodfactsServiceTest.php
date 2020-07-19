<?php

namespace AppSmart\Products\Tests\Unit;

use AppSmart\Products\Services\OpenfoodfactsService;
use Tests\TestCase;

class OpenfoodfactsServiceTest extends TestCase
{
    private $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new OpenfoodfactsService();
    }

    /**
     * check for remote service is available
     */
    public function testRemoteServiceAnswerOk()
    {
        $response = $this->get($this->service->serviceUrl);

        $this->assertTrue(in_array($response->status(), [200, 302]));
    }

    /**
     * check for remote service content exists
     */
    public function testRemoteServiceContentExists(): void
    {
        $productExistInApi = false;
        $data = $this->service->getPage(1);
        foreach ($data->products as $product) {
            if ($product->product_name == 'Eau Cristaline') {
                $productExistInApi = true;
                break;
            }
        }

        $this->assertTrue($productExistInApi);
    }

}
