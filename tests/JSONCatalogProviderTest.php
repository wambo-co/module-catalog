<?php

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\Memory\MemoryAdapter;
use Wambo\Catalog\Error\CatalogException;
use Wambo\Catalog\JSONCatalogProvider;
use Wambo\Catalog\Mapper\CatalogMapper;
use Wambo\Catalog\Mapper\ContentMapper;
use Wambo\Catalog\Mapper\ProductMapper;
use Wambo\Catalog\Model\Catalog;
use Wambo\Catalog\Model\Product;
use Wambo\Catalog\Validation\SKUValidator;
use Wambo\Catalog\Validation\SlugValidator;

/**
 * Class JSONCatalogTest tests the JSONCatalog class.
 *
 * @package Wambo\Catalog\Tests
 */
class JSONCatalogTest extends \PHPUnit_Framework_TestCase
{
    /**
     * If the JSONCatalog is empty no products should be returned.
     *
     * @test
     */
    public function getCatalog_JSONIsEmpty_NoProductsAreReturned()
    {
        // arrange
        $filesystem = new Filesystem(new MemoryAdapter());
        $catalogMapperMock = $this->getMockBuilder(CatalogMapper::class)->disableOriginalConstructor()->getMock();
        /** @var $catalogMapperMock CatalogMapper A mock for the CatalogMapper class */
        $jsonCatalog = new JSONCatalogProvider($filesystem, "catalog.json", $catalogMapperMock);

        // act
        $catalog = $jsonCatalog->getCatalog();

        // assert
        $this->assertEmpty($catalog, "getCatalog should not have returned a catalog if the catalog JSON is empty");
    }

    /**
     * If the CatalogMapper returns a catalog, the provider should return that catalog.
     *
     * @test
     * @expectedException \Wambo\Catalog\Error\CatalogException
     */
    public function getCatalog_JSONIsInvalid_CatalogExceptionIsThrown()
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
    public function getCatalog_JSONIsValid_MapperThrowsException_CatalogExceptionIsThrown()
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
    public function getCatalog_JSONIsValid_MapperReturnsCatalog_CatalogIsReturned()
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

    /**
     * Integration test with local filesystem
     *
     * @test
     */
    public function getCatalog_IntegrationTest_LocalSampleCatalogFile()
    {
        // arrange
        $sampleCatalogFilename = "sample-catalog.json";
        $testResourceFolderPath = realpath(__DIR__ . '/resources');
        $adapter = new Local($testResourceFolderPath);
        $filesystem = new Filesystem($adapter);

        $contentMapper = new ContentMapper();
        $productMapper = new ProductMapper($contentMapper);
        $catalogMapper = new CatalogMapper($productMapper);

        $jsonCatalogProvider = new JSONCatalogProvider($filesystem, $sampleCatalogFilename, $catalogMapper);

        // act
        $catalog = $jsonCatalogProvider->getCatalog();

        // assert
        foreach ($catalog->getProducts() as $product) {
            /** @var Product $product */
            $this->assertNotEmpty($product->getSku(), "The SKU should not be empty");
            $this->assertNotEmpty($product->getSlug(), "The slug should not be empty");
            $this->assertNotEmpty($product->getTitle(), "The title should not be empty");
            $this->assertNotEmpty($product->getSummaryText(), "The summary should not be empty");
            $this->assertNotEmpty($product->getProductDescription(), "The product description should not be empty");
        }
    }

    /**
     * Integration test
     *
     * @test
     */
    public function getCatalog_IntegrationTest_CatalogWithProductsIsReturned()
    {
        // arrange
        $filesystem = new Filesystem(new MemoryAdapter());
        $contentMapper = new ContentMapper();
        $productMapper = new ProductMapper($contentMapper);
        $catalogMapper = new CatalogMapper($productMapper);

        $catalogJSON = <<<JSON
[
    {
        "sku": "t-shirt-no-1",
        "slug": "t-shirt-no-1",
        "title": "T-Shirt No. 1",
        "summary": "Our T-Shirt No. 1",
        "description": "Our fancy T-Shirt No. 1 is ..."
    },
    {
        "sku": "t-shirt-no-2",
        "slug": "t-shirt-no-2",
        "title": "T-Shirt No. 2",
        "summary": "Our T-Shirt No. 2",
        "description": "Our fancy T-Shirt No. 2 is ..."
    },
    {
        "sku": "t-shirt-no-3",
        "slug": "t-shirt-no-3",
        "title": "T-Shirt No. 3",
        "summary": "Our T-Shirt No. 3",
        "description": "Our fancy T-Shirt No. 3 is ..."
    }
]
JSON;
        $filesystem->write("catalog.json", $catalogJSON);
        $jsonCatalogProvider = new JSONCatalogProvider($filesystem, "catalog.json", $catalogMapper);

        // act
        $catalog = $jsonCatalogProvider->getCatalog();

        // assert
        $this->assertCount(3, $catalog, "getCatalog should return a catalog with 3 products");
    }

    /**
     * Integration test: invalid JSON
     *
     * @test
     * @dataProvider                   getInvalidCatalogJSON
     *
     * @param string $json
     *
     * @expectedException Wambo\Catalog\Error\CatalogException
     * @expectedExceptionMessageRegExp /Unable to read catalog/
     */
    public function getCatalog_IntegrationTest_ValidCatalog_CatalogExceptionIsThrown($json)
    {
        // arrange
        $filesystem = new Filesystem(new MemoryAdapter());
        $contentMapper = new ContentMapper();
        $productMapper = new ProductMapper($contentMapper);
        $catalogMapper = new CatalogMapper($productMapper);

        $filesystem->write("catalog.json", $json);
        $jsonCatalogProvider = new JSONCatalogProvider($filesystem, "catalog.json", $catalogMapper);

        // act
        $jsonCatalogProvider->getCatalog();
    }

    /**
     * Integration test: valid catalog
     *
     * @test
     */
    public function getCatalog_IntegrationTest_ValidCatalog_AllProductAttributesAreSet()
    {
        // arrange
        $filesystem = new Filesystem(new MemoryAdapter());
        $contentMapper = new ContentMapper();
        $productMapper = new ProductMapper($contentMapper);
        $catalogMapper = new CatalogMapper($productMapper);

        $catalogJSON = <<<JSON
[
    {
        "sku": "t-shirt-no-1",
        "slug": "t-shirt-no-1-slug",
        "title": "T-Shirt No. 1",
        "summary": "Our T-Shirt No. 1",
        "description": "Our fancy T-Shirt No. 1 is ..."
    }
]
JSON;
        $filesystem->write("catalog.json", $catalogJSON);
        $jsonCatalogProvider = new JSONCatalogProvider($filesystem, "catalog.json", $catalogMapper);

        // act
        $catalog = $jsonCatalogProvider->getCatalog();

        // assert
        $products = $catalog->getProducts();
        $this->assertCount(1, $products, "getCatalog should return a catalog with one product");

        /** @var Product $firstProduct */
        $firstProduct = $products[0];
        $this->assertEquals("t-shirt-no-1", $firstProduct->getSku(), "Wrong SKU");
        $this->assertEquals("t-shirt-no-1-slug", $firstProduct->getSlug(), "Wrong slug");
        $this->assertEquals("T-Shirt No. 1", $firstProduct->getTitle(), "Wrong title");
        $this->assertEquals("Our T-Shirt No. 1", $firstProduct->getSummaryText(), "Wrong summary");
        $this->assertEquals("Our fancy T-Shirt No. 1 is ...", $firstProduct->getProductDescription(),
            "Wrong description");
    }

    /**
     * Get invalid catalog JSON for testing
     *
     * @return array
     */
    public static function getInvalidCatalogJSON()
    {
        return array(

            // JavaScript instead of JSON
            [
                <<<JSON
                var test = {
    "sku": "t-shirt-no-1",
    "slug": "t-shirt-no-1-slug",
    "title": "T-Shirt No. 1",
    "summary": "Our T-Shirt No. 1",
    "description": "Our fancy T-Shirt No. 1 is ..."
};
JSON
            ],

            // Missing attribute quotes
            [
                <<<JSON
                [
    {
        sku: "t-shirt-no-1",
        slug: "t-shirt-no-1-slug",
        title: "T-Shirt No. 1",
        summary: "Our T-Shirt No. 1",
        description: "Our fancy T-Shirt No. 1 is ..."
    }
]
JSON
            ],

            // Missing comma
            [
                <<<JSON
                [
    {
        "sku": "t-shirt-no-1"
        "slug": "t-shirt-no-1-slug"
        "title": "T-Shirt No. 1"
        "summary": "Our T-Shirt No. 1"
        "description": "Our fancy T-Shirt No. 1 is ..."
    }
]
JSON
            ],

            // Control Character
            [
                <<<JSON
                [
    {
        "sku": "t-shirt-no-1"
        "slug": "t-shirt-no-1-slug"
        "title": "T-Shirt No. 1"
        "summary": "Our T-Shirt No. 1"
        "���": "Our fancy T-Shirt No. 1 is ..."
    }
]
JSON
            ]
        );
    }
}
