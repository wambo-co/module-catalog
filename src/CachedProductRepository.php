<?php

namespace Wambo\Catalog;

use Wambo\Catalog\Cache\CacheInterface;
use Wambo\Catalog\Exception\RepositoryException;
use Wambo\Catalog\Model\Product;

/**
 * Class CachedProductRepository fetches Product models from the Storage and writes Products back to the Storage
 * while using a cache layer.
 *
 * @package Wambo\Catalog
 */
class CachedProductRepository implements ProductRepositoryInteface
{
    /**
     * @var CacheInterface
     */
    private $cache;
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * Creates a new CachedProductRepository instance.
     *
     * @param CacheInterface    $cache
     * @param ProductRepository $productRepository
     *
     */
    public function __construct(CacheInterface $cache, ProductRepository $productRepository)
    {
        $this->cache = $cache;
        $this->productRepository = $productRepository;
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
        $cacheKey = $this->cache->getKey(self::class, "products");
        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $products = $this->productRepository->getProducts();
        $this->cache->store($cacheKey, $products);

        return $products;
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