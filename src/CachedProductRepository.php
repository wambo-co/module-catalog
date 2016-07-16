<?php

namespace Wambo\Catalog;

use Psr\Cache\CacheItemPoolInterface;
use Wambo\Catalog\Exception\RepositoryException;
use Wambo\Catalog\Model\Product;

/**
 * Class CachedProductRepository fetches Product models from the Storage and writes Products back to the Storage
 * while using a cache layer.
 *
 * @package Wambo\Catalog
 */
class CachedProductRepository implements ProductRepositoryInterface
{
    /**
     * @var CacheItemPoolInterface
     */
    private $cache;
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * Creates a new CachedProductRepository instance.
     *
     * @param CacheItemPoolInterface $cache             A cache backend for storing the results
     * @param ProductRepository      $productRepository A product repository for reading and writing product data
     *
     */
    public function __construct(CacheItemPoolInterface $cache, ProductRepository $productRepository)
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
        $cacheKey = "products";
        if ($this->cache->hasItem($cacheKey)) {

            // return from cache
            $cacheItem = $this->cache->getItem($cacheKey);
            $cachedProducts = $cacheItem->get();
            return $cachedProducts;
        }

        $products = $this->productRepository->getProducts();

        // save to cache
        $cacheItem = $this->cache->getItem($cacheKey);
        $cacheItem->set($products);

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