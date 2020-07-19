<?php

namespace AppSmart\Products\Http\Controllers;

use App\Http\Controllers\Controller;
use AppSmart\Products\Models\Product;
use AppSmart\Products\Services\OpenfoodfactsService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\View\View;


class ProductController extends Controller
{
    private $productsService;

    public function __construct(OpenfoodfactsService $productsService)
    {
        $this->productsService = $productsService;
    }

    /**
     * main page of products
     */
    public function index()
    {
        $page = (int)request()->page;
        $data = $this->productsService->getPage($page);
        return $this->prepareAndReturn($data, $page);
    }

    private function prepareAndReturn($serviceData, $page, array $messages = [])
    {
        $errors = [];
        try {
            $dbItems = Product::all()->toArray();
            $serviceData->products = $this->compareWithDb((array)$serviceData->products, $dbItems);
        } catch (Exception $e) {
            $errors[] = $e->getMessage();
        }
        $page = empty($page) ? 1 : $page;
        return view('products::products', ['products' => $serviceData, 'page' => $page, 'messages' => $messages, 'errors' => $errors]);
    }

    private function compareWithDb($serviceItems, $dbItems): array
    {
        foreach ($dbItems as $dbItem) {
            $dbId = $dbItem[Product::ATTR_ID];
            foreach ($serviceItems as $serviceItemKey => $serviceItem) {
                if ($serviceItem->id == $dbId) {
                    $serviceItems[$serviceItemKey]->ALREADY_IN_DB = true;
                    break;
                }
            }
        }
        return $serviceItems;
    }

    /**
     * Searching
     * @return View
     */
    public function productSearch()
    {
        $searchText = request()->searchText;
        $page = (int)request()->page;
        $data = $this->productsService->search($searchText);
        return $this->prepareAndReturn($data, $page, ['Searching results: ']);
    }

    public function store(Request $request)
    {
        $data = [
            Product::ATTR_ID => $request->input(Product::ATTR_ID),
            Product::ATTR_NAME => $request->input(Product::ATTR_NAME),
            Product::ATTR_IMAGE => $request->input(Product::ATTR_IMAGE),
            Product::ATTR_CATEGORY => $request->input(Product::ATTR_CATEGORY),
        ];
        Product::store($data);

        $page = (int)request()->page;
        $data = $this->productsService->getPage($page);
        return $this->prepareAndReturn($data, $page, ['The product was successfully saved/updated']);
    }


}
