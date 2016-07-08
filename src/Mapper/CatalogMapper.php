<?php
namespace Wambo\Catalog\Mapper;

use Wambo\Catalog\Model\Catalog;
use Wambo\Catalog\Model\Product;

/**
 * Class CatalogMapper creates \Wambo\Model\Product models from catalog data
 *
 * @package Wambo\Mapper
 */
class CatalogMapper
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
     * CatalogMapper constructor.
     */
    public function __construct()
    {
    }

    /**
     * Get a Catalog model from the an array of catalog data
     *
     * @param string $catalogData An array containing a product catalog
     *
     * @return Product
     */
    public function getCatalog($catalogData)
    {
        if (is_null($catalogData)) {
            throw new \InvalidArgumentException("The given catalog data cannot be null");
        }

        if (!is_array($catalogData)) {
            throw new \InvalidArgumentException("The given catalog data must be an array");
        }

        return new Catalog(array());
    }
}