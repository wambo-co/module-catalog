<?php
namespace Wambo\Catalog\Tests;

use League\Flysystem\Filesystem;
use League\Flysystem\Memory\MemoryAdapter;
use Wambo\Catalog\JSONCatalog;

/**
 * Class JSONCatalogTest tests the JSONCatalog class.
 * @package Wambo\Catalog\Tests
 */
class JSONCatalogTest extends \PHPUnit_Framework_TestCase
{
    /**
     * If the JSONCatalog is empty no products should be returned.
     *
     * @test
     */
    public function getAllProducts_CatalogIsEmpty_NoProductsAreReturned()
    {
        // arrange
        $filesystem = new Filesystem(new MemoryAdapter());
        $jsonCatalog = new JSONCatalog($filesystem, "catalog.json");

        // act
        $products = $jsonCatalog->getAllProducts();

        // assert
        $this->assertEmpty($products, "getAllProducts should not have returned products");
    }

    /**
     * If the JSONCatalog contains products, products should be returned when calling getAllProducts()
     *
     * @test
     */
    public function getAllProducts_CatalogContainsProducts_ProductsAreReturned()
    {
        // arrange
        $filesystem = new Filesystem(new MemoryAdapter());
        $catalogJSON = <<<JSON
[
    {}
]
JSON;
        $filesystem->write("catalog.json", $catalogJSON);
        $jsonCatalog = new JSONCatalog($filesystem, "catalog.json");

        // act
        $products = $jsonCatalog->getAllProducts();

        // assert
        $this->assertNotEmpty($products, "getAllProducts should have returned some products");
    }
}
