<?php

namespace Wambo\Catalog\Cache;

use Wambo\Core\Module\Exception\InvalidArgumentException;
use Wambo\Core\ValueObject\ValueObjectInterface;
use Wambo\Core\ValueObject\ValueObjectTrait;

/**
 * Class DummyCache
 *
 * @package Wambo\Catalog\Cache
 */
class DummyCache implements CacheInterface
{
    private $storage;

    /**
     * Creates a new DummyCache instance.
     */
    public function __construct()
    {
        $this->storage = array();
    }

    /**
     * Get a cache key for the given element name and tags.
     *
     * @param string    $elementName A name of the element that you want to cache
     * @param \string[] $tags        A list of tags that help to categorize the element you want to cache
     *
     * @return CacheKey
     */
    public function getKey(string $elementName, string ...$tags): CacheKey
    {
        return new CacheKey($elementName, ...$tags);
    }

    /**
     * Get a flag indicating if the the cache has an element with given cache key
     *
     * @param CacheKey $cacheKey The identifier for the cached value you want to retrieve
     *
     * @return bool
     */
    public function has(CacheKey $cacheKey): bool
    {
        return array_key_exists($cacheKey->getValue(), $this->storage);
    }

    /**
     * Get the data stored under the given cache key.
     *
     * @param CacheKey $cacheKey The identifier for the cached value you want to retrieve
     *
     * @return array|null The data stored under the given cache key; null if the cache does not exist.
     */
    public function get(CacheKey $cacheKey)
    {
        if ($this->has($cacheKey) === false) {
            return null;
        }

        return $this->storage[$cacheKey->getValue()];
    }

    /**
     * Store an array under the given cache key.s
     *
     * @param CacheKey $cacheKey The identifier for the cached value you want to retrieve
     * @param array    $value    An array with data
     */
    public function store(CacheKey $cacheKey, array $value)
    {
        $this->storage[$cacheKey->getValue()] = $value;
    }

    /**
     * Remove the data stored under the given cache key
     *
     * @param CacheKey $cacheKey The identifier for the cached value you want to retrieve
     *
     * @return array|null The data that was stored under the given key; null if the key does not exist.
     */
    public function remove(CacheKey $cacheKey)
    {
        if ($this->has($cacheKey) === false) {
            return null;
        }

        $value = $this->get($cacheKey);
        unset($this->storage[$cacheKey->getValue()]);

        return $value;
    }
}