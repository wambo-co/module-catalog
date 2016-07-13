<?php

use Wambo\Catalog\Mapper\ProductMapper;
use Wambo\Catalog\Model\Content;
use Wambo\Catalog\Model\Product;
use Wambo\Catalog\Model\SKU;
use Wambo\Catalog\Model\Slug;
use Wambo\Catalog\ProductRepository;
use Wambo\Core\Storage\StorageInterface;

/**
 * Class ProductRepositoryTest tests the Wambo\Catalog\ProductRepository class.
 *
 * @package Wambo\Catalog\Tests
 */
class ProductRepositoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function getProducts_StorageReturnsEmptyArray_NoProductsAreReturned()
    {
        // arrange
        $productStorage = $this->getMockBuilder(StorageInterface::class)->getMock();
        $productStorage->method("read")->willReturn(array());
        $productMapper = $this->createMock(ProductMapper::class);

        /** @var StorageInterface $productStorage */
        /** @var ProductMapper $productMapper */
        $productRepository = new ProductRepository($productStorage, $productMapper);

        // act
        $products = $productRepository->getProducts();

        // assert
        $this->assertEmpty($products, "getProducts should not have returned an empty array");
    }

    /**
     * @test
     * @expectedException \Wambo\Catalog\Exception\RepositoryException
     */
    public function getProducts_StorageReadThrowsException_RepositoryExceptionIsThrown()
    {
        // arrange
        $productStorage = $this->getMockBuilder(StorageInterface::class)->getMock();
        $productStorage->method("read")->willThrowException(new Exception("Some error"));

        $productMapper = $this->createMock(ProductMapper::class);

        /** @var StorageInterface $productStorage */
        /** @var ProductMapper $productMapper */
        $productRepository = new ProductRepository($productStorage, $productMapper);

        // act
        $productRepository->getProducts();
    }

    /**
     * @test
     */
    public function getProducts_StorageReturnsOneProduct_ProductMapperReturnsProduct_ProductIsReturned()
    {
        // arrange
        $productStorage = $this->getMockBuilder(StorageInterface::class)->getMock();
        $productStorage->method("read")->willReturn(array(
            [
                "sku" => "product-a"
            ],
        ));

        $productMapper = $this->getMockBuilder(ProductMapper::class)->disableOriginalConstructor()->getMock();
        $productMapper->method("getProduct")->willReturn(new Product(new SKU("product-a"),
            new Slug("a-product"), new Content("A product", "A description", "...")));

        /** @var StorageInterface $productStorage */
        /** @var ProductMapper $productMapper */
        $productRepository = new ProductRepository($productStorage, $productMapper);

        // act
        $products = $productRepository->getProducts();

        // assert
        $this->assertCount(1, $products);

        /** @var Product $product */
        $product = $products[0];
        $this->assertEqual("product-a", $product->getSKU());
    }
}
