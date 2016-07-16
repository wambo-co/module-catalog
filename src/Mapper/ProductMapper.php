<?php
namespace Wambo\Catalog\Mapper;

use Wambo\Catalog\Exception\ProductException;
use Wambo\Catalog\Model\Product;
use Wambo\Catalog\Model\SKU;
use Wambo\Catalog\Model\Slug;

/**
 * Class ProductMapper creates \Wambo\Model\Product models from data bags with product data.
 *
 * @package Wambo\Mapper
 */
class ProductMapper
{
    const FIELD_SKU = "sku";
    const FIELD_SLUG = "slug";

    /**
     * @var array $mandatoryFields A list of all mandatory fields of a Product
     */
    private $mandatoryFields = [self::FIELD_SKU, self::FIELD_SLUG];

    /**
     * @var ContentMapper
     */
    private $contentMapper;

    /**
     * Creates a new ProductMapper instance
     *
     * @param ContentMapper $contentMapper A class for mapping product content
     */
    public function __construct(ContentMapper $contentMapper)
    {
        $this->contentMapper = $contentMapper;
    }

    /**
     * Get a Catalog model from an array of unstructured product data
     *
     * @param array $productData An array containing product attributes
     *
     * @return Product
     *
     * @throws ProductException If a mandatory field is missing
     * @throws ProductException If the no Product could be created from the given product data
     */
    public function getProduct(array $productData)
    {
        // check if all mandatory fields are present
        foreach ($this->mandatoryFields as $mandatoryField) {
            if (!array_key_exists($mandatoryField, $productData)) {
                throw new ProductException("The field '$mandatoryField' is missing in the given product data");
            }
        }

        // try to create a product from the available data
        try {

            // sku
            $sku = new SKU($productData[self::FIELD_SKU]);

            // slug
            $slug = new Slug($productData[self::FIELD_SLUG]);

            // product content
            $content = $this->contentMapper->getContent($productData);

            $product = new Product($sku, $slug, $content);
            return $product;

        } catch (\Exception $productException) {
            throw new ProductException(sprintf("Failed to create a product from the given data: %s",
                $productException->getMessage()), $productException);
        }
    }
}