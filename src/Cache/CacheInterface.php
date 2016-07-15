<?php
/**
 * Created by PhpStorm.
 * User: andyk
 * Date: 15/07/16
 * Time: 20:51
 */
namespace Wambo\Catalog\Cache;


/**
 * The CacheInterface interface provides functions for storing, retrieving, checking and deleting cached data.
 *
 * @package Wambo\Catalog\Cache
 */
interface CacheInterface
{
    /**
     * Get a cache key for the given element name and tags.
     *
     * @param string    $elementName A name of the element that you want to cache
     * @param \string[] $tags        A list of tags that help to categorize the element you want to cache
     *
     * @return CacheKey
     */
    public function getKey(string $elementName, string ...$tags) : CacheKey;

    /**
     * Get a flag indicating if the the cache has an element with given cache key
     *
     * @param CacheKey $cacheKey The identifier for the cached value you want to retrieve
     *
     * @return bool
     */
    public function has(CacheKey $cacheKey) : bool;

    /**
     * Get the data stored under the given cache key.
     *
     * @param CacheKey $cacheKey The identifier for the cached value you want to retrieve
     *
     * @return array
     */
    public function get(CacheKey $cacheKey);

    /**
     * Store an array under the given cache key.s
     *
     * @param CacheKey $cacheKey The identifier for the cached value you want to retrieve
     * @param array    $value    An array with data
     */
    public function store(CacheKey $cacheKey, array $value);

    /**
     * Remove the data stored under the given cache key
     *
     * @param CacheKey $cacheKey The identifier for the cached value you want to retrieve
     *
     * @return array|null The data that was stored under the given key; null if the key does not exist.
     */
    public function remove(CacheKey $cacheKey);
}