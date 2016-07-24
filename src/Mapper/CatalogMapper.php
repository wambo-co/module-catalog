<?php
namespace Wambo\Catalog\Mapper;

use Wambo\Catalog\Exception\CatalogException;
use Wambo\Catalog\Model\Catalog;

/**
 * Class CatalogMapper creates \Wambo\Model\Product models from catalog data
 *
 * @package Wambo\Mapper
 */
class CatalogMapper
{
    /**
     * @var ProductMapper
     */
    private $productMapper;

    /**
     * Creates a new instance of the CatalogMapper class.
     *
     * @param ProductMapper $productMapper A ProductMapper instance for converting unstructured product data to Product
     *                                     models
     */
    public function __construct(ProductMapper $productMapper)
    {
        $this->productMapper = $productMapper;
    }

    /**
     * Get a Catalog model from the an array of catalog data
     *
     * @param array $catalogData An array containing a product catalog
     *
     * @return Catalog
     *
     * @throws CatalogException If the catalog cannot be created
     */
    public function getCatalog(array $catalogData)
    {
        /** @var array $skuIndex A list of all SKUs */
        $skuIndex = [];

        /** @var array $slugIndex A list of all product slugs */
        $slugIndex = [];

        $index = 1;
        $products = [];
        foreach ($catalogData as $catalogItem) {

            try {
                // convert the product data into a Product model
                $product = $this->productMapper->getProduct($catalogItem);

                // check for duplicate SKUs
                $sku = strtolower($product->getSku()->__toString());
                if (array_key_exists($sku, $skuIndex)) {
                    throw new CatalogException(sprintf("Cannot add a second product with the SKU '%s' to the catalog",
                        $sku));
                }
                $skuIndex[$sku] = 1;

                // check for duplicate Slugs
                $slug = strtolower($product->getSlug()->__toString());
                if (array_key_exists($slug, $slugIndex)) {
                    throw new CatalogException(sprintf("Cannot add a second product with the Slug '%s' to the catalog",
                        $slug));
                }
                $slugIndex[$slug] = 1;

                // add the product to the catalog
                $products[] = $product;

            } catch (\Exception $productException) {
                throw new CatalogException(sprintf("Cannot convert catalog item %s into a product: %s", $index,
                    $productException->getMessage()), $productException);
            }

            $index++;
        }

        return new Catalog($products);
    }
}