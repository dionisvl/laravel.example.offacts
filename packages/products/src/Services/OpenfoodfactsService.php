<?php

namespace AppSmart\Products\Services;

use AppSmart\Products\Models\Product;
use Illuminate\Support\Facades\Http;

/**
 * Products service
 */
class OpenfoodfactsService
{
    public $serviceUrl = "https://world.openfoodfacts.org/";

    public function getPage(int $page): object
    {
        $url = "cgi/search.pl?action=process&sort_by=unique_scans_n&page_size=20&json=1&page=$page";
        //$url = "cgi/search.pl?search_terms=banan&search_simple=1&action=process&json=1";
        return $this->getResponse($url);
    }

    private function getResponse(string $url)
    {
        $url = $this->serviceUrl . $url;
        $response = Http::timeout(10)->get($url);
        $data = json_decode($response->body());
        $data = $this->clear($data);
        return $data;
    }

    /**
     * In this example, we will skip products that are incomplete
     * @param object $data
     * @return object
     */
    private function clear(object $data): object
    {
        $data = (array)$data;
        foreach ($data['products'] as $key => $product) {
            if (empty($product->id)) {
                unset ($data['products'][$key]);
            }
            if (empty($product->categories)) {
                unset ($data['products'][$key]);
            }
            if (empty($product->image_url)) {
                unset ($data['products'][$key]);
            }
        }
        return (object)$data;
    }

    public function search(string $text): object
    {
        $url = "cgi/search.pl?search_terms=$text&search_simple=1&action=process&json=1";
        return $this->getResponse($url);
    }
}
