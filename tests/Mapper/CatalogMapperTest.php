<?php

use Wambo\Catalog\Mapper\CatalogMapper;
use Wambo\Catalog\Mapper\ProductMapper;
use Wambo\Catalog\Model\Content;
use Wambo\Catalog\Model\Product;
use Wambo\Catalog\Model\SKU;
use Wambo\Catalog\Model\Slug;

/**
 * Class CatalogMapperTest contains tests for the CatalogMapper class.
 */
class CatalogMapperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function getCatalog_EmptyArrayIsGiven_EmptyCatalogIsReturned()
    {
        // arrange
        $catalogData = array();
        $productMapperMock = $this->getMockBuilder(ProductMapper::class)->disableOriginalConstructor()->getMock();
        /** @var ProductMapper $productMapperMock A product mapper instance */

        $productMapper = new CatalogMapper($productMapperMock);


        // act
        $result = $productMapper->getCatalog($catalogData);

        // assert
        $this->assertNotNull($result, "getCatalog should have returned an empty catalog");
    }

    /**
     * When the product mapper throws an exception the getCatalog function should throw a CatalogException
     *
     * @test
     * @expectedException Wambo\Catalog\Error\CatalogException
     */
    public function getCatalog_ArrayOfTwoProductsGiven_ProductMapperThrowsException_CatalogExceptionIsThrown()
    {
        // arrange
        $catalogData = [
            ["sku" => "0001"],
            ["sku" => "0002"],
        ];
        $productMapperMock = $this->createMock(ProductMapper::class);
        $productMapperMock->method("getProduct")->willThrowException(new Exception("Some product mapper exception"));

        /** @var ProductMapper $productMapperMock A product mapper instance */

        $productMapper = new CatalogMapper($productMapperMock);


        // act
        $productMapper->getCatalog($catalogData);
    }

    /**
     * If the the given product catalog data contains products with duplicate SKUs a
     * Wambo\Catalog\Error\CatalogException should be thrown.
     *
     * @test
     *
     * @expectedException Wambo\Catalog\Error\CatalogException
     * @expectedExceptionMessageRegExp /Cannot add a second product with the SKU '.+'/
     */
    public function getCatalog_ArrayWithDuplicateSKUGiven_CatalogExceptionIsThrown()
    {
        // arrange
        $catalogData = [
            ["sku" => "0001"],
            ["sku" => "0002"],
            ["sku" => "0001"],
        ];

        $productMapperMock = $this->getMockBuilder(ProductMapper::class)->disableOriginalConstructor()->getMock();
        $productMapperMock->method("getProduct")->will($this->onConsecutiveCalls(
            new Product(new SKU("0001"), new Slug("product-1"), "Product 1", new Content("Summary")),
            new Product(new SKU("0002"), new Slug("product-2"), "Product 2", new Content("Summary")),
            new Product(new SKU("0001"), new Slug("product-1a"), "Product 1a", new Content("Summary")))
        );

        /** @var ProductMapper $productMapperMock A product mapper instance */

        $productMapper = new CatalogMapper($productMapperMock);

        // act
        $productMapper->getCatalog($catalogData);
    }

    /**
     * If the the given product catalog data contains products with duplicate Slugs a
     * Wambo\Catalog\Error\CatalogException should be thrown.
     *
     * @test
     *
     * @expectedException Wambo\Catalog\Error\CatalogException
     * @expectedExceptionMessageRegExp /Cannot add a second product with the Slug 'product-1'/
     */
    public function getCatalog_ArrayWithDuplicateSlugsGiven_CatalogExceptionIsThrown()
    {
        // arrange
        $catalogData = [
            ["sku" => "0001"],
            ["sku" => "0002"],
            ["sku" => "0003"],
        ];

        $productMapperMock = $this->getMockBuilder(ProductMapper::class)->disableOriginalConstructor()->getMock();
        $productMapperMock->method("getProduct")->will($this->onConsecutiveCalls(
            new Product(new SKU("0001"), new Slug("product-1"), "Product 1", new Content("Summary")),
            new Product(new SKU("0002"), new Slug("product-2"), "Product 2", new Content("Summary")),
            new Product(new SKU("0003"), new Slug("product-1"), "Product 3", new Content("Summary")))
        );

        /** @var ProductMapper $productMapperMock A product mapper instance */

        $productMapper = new CatalogMapper($productMapperMock);

        // act
        $productMapper->getCatalog($catalogData);
    }

    /**
     * If the the given product catalog data contains products with similar SKUs a
     * Wambo\Catalog\Error\CatalogException should be thrown.
     *
     * @test
     *
     * @expectedException Wambo\Catalog\Error\CatalogException
     * @expectedExceptionMessageRegExp /Cannot add a second product with the SKU 'product'/
     */
    public function getCatalog_ArrayWithSimilarSKUsGiven_CatalogExceptionIsThrown()
    {
        // arrange
        $catalogData = [
            ["sku" => "0001"],
            ["sku" => "0002"],
            ["sku" => "0003"],
        ];

        $productMapperMock = $this->createMock(ProductMapper::class);
        $productMapperMock->method("getProduct")->will($this->onConsecutiveCalls(
            new Product(new SKU("product"), new Slug("product-a"), "Product 1", new Content("Summary")),
            new Product(new SKU("product"), new Slug("product-b"), "Product 2", new Content("Summary")))
        );

        /** @var ProductMapper $productMapperMock A product mapper instance */

        $productMapper = new CatalogMapper($productMapperMock);

        // act
        $productMapper->getCatalog($catalogData);
    }

    /**
     * If the the given product catalog data contains products with similar slugs a
     * Wambo\Catalog\Error\CatalogException should be thrown.
     *
     * @test
     *
     * @expectedException Wambo\Catalog\Error\CatalogException
     * @expectedExceptionMessageRegExp /Cannot add a second product with the Slug 'a-product'/
     */
    public function getCatalog_ArrayWithSimilarSlugsGiven_CatalogExceptionIsThrown()
    {
        // arrange
        $catalogData = [
            ["sku" => "0001"],
            ["sku" => "0002"],
            ["sku" => "0003"],
        ];

        $productMapperMock = $this->getMockBuilder(ProductMapper::class)->disableOriginalConstructor()->getMock();
        $productMapperMock->method("getProduct")->will($this->onConsecutiveCalls(
            new Product(new SKU("0001"), new Slug("a-product"), "Product 1", new Content("Summary")),
            new Product(new SKU("0002"), new Slug("A-Product"), "Product 2", new Content("Summary")))
        );

        /** @var ProductMapper $productMapperMock A product mapper instance */

        $productMapper = new CatalogMapper($productMapperMock);

        // act
        $productMapper->getCatalog($catalogData);
    }

    /**
     * @test
     */
    public function getCatalog_ArrayOfTwoProductsGiven_ProductMapperReturnsProducts_CatalogWithTwoProductsIsReturned()
    {
        // arrange
        $catalogData = [
            ["sku" => "0001"],
            ["sku" => "0002"],
        ];

        $productMapperMock = $this->createMock(ProductMapper::class);
        $productMapperMock->method("getProduct")->will($this->onConsecutiveCalls(
            new Product(new SKU("0001"), new Slug("product-1"), "Product 1", new Content("Summary")),
            new Product(new SKU("0002"), new Slug("product-2"), "Product 2", new Content("Summary")))
        );

        /** @var ProductMapper $productMapperMock A product mapper instance */

        $productMapper = new CatalogMapper($productMapperMock);


        // act
        $catalog = $productMapper->getCatalog($catalogData);

        // assert
        $this->assertCount(2, $catalog, "The catalog should contain two products");
    }
}