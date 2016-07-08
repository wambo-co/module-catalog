<?php
namespace Wambo\Catalog\Mapper;

use Wambo\Catalog\Model\Product;

/**
 * Class ProductMapper creates \Wambo\Model\Product models from data bags with product data.
 *
 * @package Wambo\Mapper
 */
class ProductMapper
{
    const FIELD_SKU = "sku";
    const FIELD_TITLE = "title";
    const FIELD_SUMMARY = "summary";
    const FIELD_SLUG = "slug";

    /**
     * @var array $mandatoryFields A list of all mandatory fields of a Product
     */
    private $mandatoryFields = [self::FIELD_SKU, self::FIELD_TITLE, self::FIELD_SUMMARY, self::FIELD_SLUG];

    /**
     * ProductMapper constructor.
     */
    public function __construct()
    {
    }

    /**
     * Get a Catalog model from an array of unstructured product data
     *
     * @param string $productData An array containing product attributes
     *
     * @return Product
     */
    public function getProduct($productData)
    {
    }
}