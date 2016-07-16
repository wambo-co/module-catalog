<?php

namespace Wambo\Catalog;

use Wambo\Catalog\Exception\RepositoryException;
use Wambo\Catalog\Mapper\ProductMapper;
use Wambo\Catalog\Model\Product;
use Wambo\Core\Storage\StorageInterface;

/**
 * Class ProductRepository fetches Product models from the Storage and writes Products back to the Storage
 *
 * @package Wambo\Catalog
 */
class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @var StorageInterface
     */
    private $productStorage;
    /**
     * @var ProductMapper
     */
    private $productMapper;

    /**
     * Creates a new ProductRepository instance.
     *
     * @param StorageInterface $productStorage A product storage for reading and writing product data
     * @param ProductMapper    $productMapper  A product mapper for mapping unstructured data to Product models and
     *                                         vice versa
     */
    public function __construct(StorageInterface $productStorage, ProductMapper $productMapper)
    {
        $this->productStorage = $productStorage;
        $this->productMapper = $productMapper;
    }

    /**
     * Get all products
     *
     * @return Product[]
     *
     * @throws RepositoryException If fetching the products failed
     */
    public function getProducts()
    {
        try {

            // read product data from storage
            $productDataArray = $this->productStorage->read();

            // deserialize the product data
            $products = [];
            foreach ($productDataArray as $productData) {
                $products[] = $this->productMapper->getProduct($productData);
            }

            return $products;

        } catch (\Exception $readException) {
            throw new RepositoryException("Failed to read products from storage provider.", $readException);
        }
    }

    public function getById(string $id)
    {
        throw new RepositoryException("Not implemented yet");
    }

    public function add(Product $product)
    {
        throw new RepositoryException("Not implemented yet");
    }

    public function remove(Product $product)
    {
        throw new RepositoryException("Not implemented yet");
    }
}