<?php

namespace AppSmart\Products\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * OpenFood Product/item model
 */
class Product extends Model
{
    const ATTR_ID = 'id';
    const ATTR_IMAGE = 'image_url';
    const ATTR_NAME = 'product_name';
    const ATTR_CATEGORY = 'categories';

    protected $primaryKey = "product_name";

    protected $fillable = ['id', 'product_name', 'image_url', 'categories'];

    public static function store(array $data): Product
    {
        return Product::updateOrCreate(
            [self::ATTR_NAME => $data[self::ATTR_NAME]],
            [
                self::ATTR_ID => $data[self::ATTR_ID],
                self::ATTR_NAME => $data[self::ATTR_NAME],
                self::ATTR_IMAGE => $data[self::ATTR_IMAGE],
                self::ATTR_CATEGORY => $data[self::ATTR_CATEGORY],
            ]
        );
    }
}
