<?php
namespace Wambo\Catalog\Tests;

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
        $jsonCatalog = new JSONCatalog();

        // act
        $products = $jsonCatalog->getAllProducts();

        // assert
        $this->assertEmpty($products);
    }
}
