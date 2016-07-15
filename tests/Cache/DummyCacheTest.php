<?php
use Wambo\Catalog\Cache\DummyCache;

/**
 * Class DummyCacheTest tests the Wambo\Catalog\Cache\DummyCache class
 */
class DummyCacheTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider getValidCacheKeyParameters
     *
     * @param string   $elementName
     * @param string[] $tags
     */
    public function getKey_ValidInput_CacheKeyIsReturned(string $elementName, string ... $tags) {
        // arrange
        $cache = new DummyCache();

        // act
        $result = $cache->getKey($elementName, ...$tags);

        // assert
        $this->assertNotNull($result);
    }

    /**
     * @test
     * @dataProvider getInvalidCacheKeyParameters
     * @expectedException InvalidArgumentException
     *
     * @param string   $elementName
     * @param string[] $tags
     */
    public function getKey_InvalidInput_InvalidArgumentExceptionIsThrown(string $elementName, string ... $tags) {
        // arrange
        $cache = new DummyCache();

        // act
        $cache->getKey($elementName, ...$tags);
    }

    /**
     * @test
     */
    public function hasKey_KeyHasNotBeenSetBefore_ResultIsFalse() {
        // arrange
        $cache = new DummyCache();
        $key = $cache->getKey("test");

        // act
        $result = $cache->has($key);

        // assert
        $this->assertFalse($result);
    }

    /**
     * @test
     */
    public function hasKey_KeyHasBeenSetBefore_ResultIsTrue() {
        // arrange
        $cache = new DummyCache();
        $key = $cache->getKey("test");
        $cache->store($key, array());

        // act
        $result = $cache->has($key);

        // assert
        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function get_KeyDoesNotExist_ResultIsNull() {
        // arrange
        $cache = new DummyCache();
        $key = $cache->getKey("non-existing-key");

        // act
        $result = $cache->get($key);

        // assert
        $this->assertNull($result);
    }

    /**
     * @test
     */
    public function get_KeyExists_ResultIsNotNull() {
        // arrange
        $cache = new DummyCache();
        $key = $cache->getKey("existing-key");
        $cache->store($key, array("dummy data"));

        // act
        $result = $cache->get($key);

        // assert
        $this->assertNotNull($result);
    }

    /**
     * @test
     */
    public function remove_KeyExists_ResultIsNotNull() {
        // arrange
        $cache = new DummyCache();
        $key = $cache->getKey("existing-key");
        $cache->store($key, array("dummy data"));

        // act
        $result = $cache->remove($key);

        // assert
        $this->assertNotNull($result);
    }

    /**
     * @test
     */
    public function remove_KeyDoesNotExist_ResultIsNull() {
        // arrange
        $cache = new DummyCache();
        $key = $cache->getKey("existing-key");

        // act
        $result = $cache->remove($key);

        // assert
        $this->assertNull($result);
    }


    /**
     * Get valid cache key parameters for testing
     */
    public static function getValidCacheKeyParameters() {
        return array(
            [ "products" ],
            [ "Products" ],
            [ " Products " ],
            [ "products", "repository" ],
            [ "PRoducts", "repository", "all" ],
            [ " PRoducts", "repoSItory ", "all " ],
        );
    }

    /**
     * Get invalid cache key parameters for testing
     */
    public static function getInvalidCacheKeyParameters() {
        return array(
            [ "" ],
            [ "  " ],
            [ "products", "" ],
            [ "products", "", "  " ],
            [ "products", "", "ds", "  " ],
        );
    }
}
