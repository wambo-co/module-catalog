<?php
namespace Wambo\Catalog\Mapper;

use Wambo\Catalog\Error\ProductException;
use Wambo\Catalog\Model\Product;
use Wambo\Catalog\Validation\SKUValidator;
use Wambo\Catalog\Validation\SlugValidator;

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
     * @var SKUValidator
     */
    private $SKUValidator;
    /**
     * @var SlugValidator
     */
    private $slugValidator;

    /**
     * Creates a new ProductMapper instance
     *
     * @param SKUValidator  $SKUValidator A class for validating SKUs
     * @param SlugValidator $slugValidator A class for validating slugs
     */
    public function __construct(SKUValidator $SKUValidator, SlugValidator $slugValidator)
    {
        $this->SKUValidator = $SKUValidator;
        $this->slugValidator = $slugValidator;
    }

    /**
     * Get a Catalog model from an array of unstructured product data
     *
     * @param array $productData An array containing product attributes
     *
     * @return Product
     *
     * @throws ProductException If the no Product could be created from the given product data
     */
    public function getProduct(array $productData)
    {
        // check if all mandatory fields are present
        foreach ($this->mandatoryFields as $mandatoryField) {
            if (!array_key_exists($mandatoryField, $productData)) {
                throw new \InvalidArgumentException("The field '$mandatoryField' is missing in the given product data");
            }
        }

        // try to create a product from the available data
        try {

            // sku
            $sku = $productData[self::FIELD_SKU];
            $this->SKUValidator->validateSKU($sku);

            // slug
            $slug = $productData[self::FIELD_SLUG];
            $this->slugValidator->validateSlug($slug);

            $title = $productData[self::FIELD_TITLE];
            $summary = $productData[self::FIELD_SUMMARY];

            $product = new Product($sku, $slug, $title, $summary);
            return $product;

        } catch (\Exception $productException) {
            throw new ProductException(sprintf("Failed to create a product from the given data: %s",
                $productException->getMessage()), $productException);
        }
    }
}