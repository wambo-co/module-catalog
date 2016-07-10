<?php

use Wambo\Catalog\Mapper\CatalogMapper;
use Wambo\Catalog\Mapper\ProductMapper;
use Wambo\Catalog\Model\Content;
use Wambo\Catalog\Model\Product;

/**
 * Class CatalogMapperTest contains tests for the CatalogMapper class.
 */
class CatalogMapperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function getCatalog_NullIsGiven_InvalidArgumentExceptionIsThrown()
    {
        // arrange
        $catalogData = null;
        $productMapperMock = $this->getMockBuilder(ProductMapper::class)->disableOriginalConstructor()->getMock();
        /** @var ProductMapper $productMapper A product mapper instance */

        $productMapper = new CatalogMapper($productMapperMock);

        // act
        $productMapper->getCatalog($catalogData);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function getCatalog_stdClassIsGiven_InvalidArgumentExceptionIsThrown()
    {
        // arrange
        $catalogData = new stdClass();
        $productMapperMock = $this->getMockBuilder(ProductMapper::class)->disableOriginalConstructor()->getMock();
        /** @var ProductMapper $productMapper A product mapper instance */

        $productMapper = new CatalogMapper($productMapperMock);


        // act
        $productMapper->getCatalog($catalogData);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function getCatalog_StringIsGiven_InvalidArgumentExceptionIsThrown()
    {
        // arrange
        $catalogData = "";
        $productMapperMock = $this->getMockBuilder(ProductMapper::class)->disableOriginalConstructor()->getMock();
        /** @var ProductMapper $productMapper A product mapper instance */

        $productMapper = new CatalogMapper($productMapperMock);


        // act
        $productMapper->getCatalog($catalogData);
    }

    /**
     * @test
     */
    public function getCatalog_EmptyArrayIsGiven_EmptyCatalogIsReturned()
    {
        // arrange
        $catalogData = array();
        $productMapperMock = $this->getMockBuilder(ProductMapper::class)->disableOriginalConstructor()->getMock();
        /** @var ProductMapper $productMapper A product mapper instance */

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
            ["sku" => "1"],
            ["sku" => "2"],
        ];
        $productMapperMock = $this->getMockBuilder(ProductMapper::class)->disableOriginalConstructor()->getMock();
        $productMapperMock->method("getProduct")->willThrowException(new Exception("Some product mapper exception"));

        /** @var ProductMapper $productMapper A product mapper instance */

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
     * @expectedExceptionMessageRegExp /Cannot add a second product with the SKU '1'/
     */
    public function getCatalog_ArrayWithDuplicateSKUGiven_CatalogExceptionIsThrown()
    {
        // arrange
        $catalogData = [
            ["sku" => "1"],
            ["sku" => "2"],
            ["sku" => "1"],
        ];

        $productMapperMock = $this->getMockBuilder(ProductMapper::class)->disableOriginalConstructor()->getMock();
        $productMapperMock->method("getProduct")->will($this->onConsecutiveCalls(
            new Product("1", "product-1", "Product 1", new Content("Summary")),
            new Product("2", "product-2", "Product 2", new Content("Summary")),
            new Product("1", "product-1a", "Product 1a", new Content("Summary")))
        );

        /** @var ProductMapper $productMapper A product mapper instance */

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
            ["sku" => "1"],
            ["sku" => "2"],
            ["sku" => "3"],
        ];

        $productMapperMock = $this->getMockBuilder(ProductMapper::class)->disableOriginalConstructor()->getMock();
        $productMapperMock->method("getProduct")->will($this->onConsecutiveCalls(
            new Product("1", "product-1", "Product 1", new Content("Summary")),
            new Product("2", "product-2", "Product 2", new Content("Summary")),
            new Product("3", "product-1", "Product 3", new Content("Summary")))
        );

        /** @var ProductMapper $productMapper A product mapper instance */

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
            ["sku" => "1"],
            ["sku" => "2"],
            ["sku" => "3"],
        ];

        $productMapperMock = $this->getMockBuilder(ProductMapper::class)->disableOriginalConstructor()->getMock();
        $productMapperMock->method("getProduct")->will($this->onConsecutiveCalls(
            new Product("product", "product-a", "Product 1", new Content("Summary")),
            new Product("ProDuct", "product-b", "Product 2", new Content("Summary")))
        );

        /** @var ProductMapper $productMapper A product mapper instance */

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
            ["sku" => "1"],
            ["sku" => "2"],
            ["sku" => "3"],
        ];

        $productMapperMock = $this->getMockBuilder(ProductMapper::class)->disableOriginalConstructor()->getMock();
        $productMapperMock->method("getProduct")->will($this->onConsecutiveCalls(
            new Product("1", "a-product", "Product 1", new Content("Summary")),
            new Product("2", "A-Product", "Product 2", new Content("Summary")))
        );

        /** @var ProductMapper $productMapper A product mapper instance */

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
            ["sku" => "1"],
            ["sku" => "2"],
        ];

        $productMapperMock = $this->createMock(ProductMapper::class);
        $productMapperMock->method("getProduct")->will($this->onConsecutiveCalls(
            new Product("1", "product-1", "Product 1", new Content("Summary")),
            new Product("2", "product-2", "Product 2", new Content("Summary")))
        );

        /** @var ProductMapper $productMapper A product mapper instance */

        $productMapper = new CatalogMapper($productMapperMock);


        // act
        $catalog = $productMapper->getCatalog($catalogData);

        // assert
        $this->assertCount(2, $catalog, "The catalog should contain two products");
    }
}