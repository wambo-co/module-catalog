<?php

use League\Flysystem\Filesystem;
use League\Flysystem\Memory\MemoryAdapter;
use Wambo\Catalog\Error\CatalogException;
use Wambo\Catalog\JSONCatalogProvider;
use Wambo\Catalog\Mapper\CatalogMapper;
use Wambo\Catalog\Model\Catalog;

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
    public function getAllProducts_JSONIsEmpty_NoProductsAreReturned()
    {
        // arrange
        $filesystem = new Filesystem(new MemoryAdapter());
        $catalogMapperMock = $this->getMockBuilder(CatalogMapper::class)->disableOriginalConstructor()->getMock();
        /** @var $catalogMapperMock CatalogMapper A mock for the CatalogMapper class */
        $jsonCatalog = new JSONCatalogProvider($filesystem, "catalog.json", $catalogMapperMock);

        // act
        $catalog = $jsonCatalog->getCatalog();

        // assert
        $this->assertEmpty($catalog, "getAllProducts should not have returned a catalog if the catalog JSON is empty");
    }

    /**
     * If the CatalogMapper returns a catalog, the provider should return that catalog.
     *
     * @test
     * @expectedException \Wambo\Catalog\Error\CatalogException
     */
    public function getAllProducts_JSONIsInvalid_CatalogExceptionIsThrown()
    {
        // arrange
        $filesystem = new Filesystem(new MemoryAdapter());
        $catalogMapperMock = $this->getMockBuilder(CatalogMapper::class)->disableOriginalConstructor()->getMock();
        $catalogMapperMock->method("getCatalog")->willReturn(new Catalog(array()));
        /** @var $catalogMapperMock CatalogMapper A mock for the CatalogMapper class */

        $catalogJSON = <<<JSON
[
    {},,],,
]
JSON;
        $filesystem->write("catalog.json", $catalogJSON);
        $jsonCatalogProvider = new JSONCatalogProvider($filesystem, "catalog.json", $catalogMapperMock);

        // act
        $jsonCatalogProvider->getCatalog();
    }

    /**
     * If the CatalogMapper throws an exception, the provider should throw a CatalogException.
     *
     * @test
     * @expectedException Wambo\Catalog\Error\CatalogException
     */
    public function getAllProducts_JSONIsValid_MapperThrowsException_CatalogExceptionIsThrown()
    {
        // arrange
        $filesystem = new Filesystem(new MemoryAdapter());
        $catalogMapperMock = $this->getMockBuilder(CatalogMapper::class)->disableOriginalConstructor()->getMock();
        $catalogMapperMock->method("getCatalog")->willThrowException(new Exception("Some mapping error"));
        /** @var $catalogMapperMock CatalogMapper A mock for the CatalogMapper class */

        $catalogJSON = <<<JSON
[]
JSON;
        $filesystem->write("catalog.json", $catalogJSON);
        $jsonCatalogProvider = new JSONCatalogProvider($filesystem, "catalog.json", $catalogMapperMock);

        // act
        $jsonCatalogProvider->getCatalog();
    }

    /**
     * If the CatalogMapper returns a catalog, the provider should return that catalog.
     *
     * @test
     */
    public function getAllProducts_JSONIsValid_MapperReturnsCatalog_CatalogIsReturned()
    {
        // arrange
        $filesystem = new Filesystem(new MemoryAdapter());
        $catalogMapperMock = $this->getMockBuilder(CatalogMapper::class)->disableOriginalConstructor()->getMock();
        $catalogMapperMock->method("getCatalog")->willReturn(new Catalog(array()));
        /** @var $catalogMapperMock CatalogMapper A mock for the CatalogMapper class */

        $catalogJSON = <<<JSON
[
    {}
]
JSON;
        $filesystem->write("catalog.json", $catalogJSON);
        $jsonCatalogProvider = new JSONCatalogProvider($filesystem, "catalog.json", $catalogMapperMock);

        // act
        $catalog = $jsonCatalogProvider->getCatalog();

        // assert
        $this->assertNotNull($catalog, "getCatalog should return a catalog if the mapper returned one");
    }
}
