<?php
namespace Wambo\Catalog\Cache;

use Wambo\Core\Module\Exception\InvalidArgumentException;
use Wambo\Core\ValueObject\ValueObjectInterface;
use Wambo\Core\ValueObject\ValueObjectTrait;

/**
 * Class CacheKey represents a single cache key used to identify elements in a cache storage.
 *
 * @package Wambo\Catalog\Cache
 */
class CacheKey implements ValueObjectInterface
{
    use ValueObjectTrait;
    private $value;

    /**
     * Create a new cache key instance for the given element name and tags.
     *
     * @param string    $elementName A name of the element that you want to cache
     * @param \string[] $tags        A list of tags that help to categorize the element you want to cache
     *
     * @return CacheKey
     */
    function __construct(string $elementName, string ...$tags)
    {
        $key = sprintf("%s--%s", $this->getCacheKeyPrefix(...$tags), $this->getCleanedName($elementName));
        $this->value = $key;

        $this->setConstructed();
    }

    /**
     * Get the value of the cache key
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get a cache key prefix from the given tags (default: "none")
     *
     * @param \string[] ...$tags A list of tags that help to categorize the element you want to cache
     *
     * @return string
     */
    private function getCacheKeyPrefix(string ...$tags): string
    {
        if (count($tags) === 0) {
            return "none"; // default prefix if no tags were given
        }

        // sort the tags alphabetically
        sort($tags);

        // assemble the prefix
        $prefix = "";
        foreach ($tags as $tag) {

            $cleanedTag = $this->getCleanedName($tag);

            if (strlen($prefix) == 0) {
                $prefix = "$cleanedTag";
                continue;
            }

            $prefix = "$prefix,$cleanedTag";
        }

        return $prefix;
    }

    /**
     * Get a cleaned cache key name for the given element name
     *
     * @param string $elementName
     *
     * @return string
     *
     * @throws InvalidArgumentException If the given element name is empty
     */
    private function getCleanedName(string $elementName): string
    {
        $trimmedElementName = trim($elementName);
        if (strlen($trimmedElementName) == 0) {
            throw new InvalidArgumentException("The element name cannot be empty");
        }

        return strtolower($trimmedElementName);
    }
}