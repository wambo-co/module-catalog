<?php
use Psr\Cache\CacheItemPoolInterface;
use Wambo\Catalog\CachedProductRepository;
use Wambo\Catalog\Model\Content;
use Wambo\Catalog\Model\Product;
use Wambo\Core\Model\SKU;
use Wambo\Catalog\Model\Slug;
use Wambo\Catalog\ProductRepository;

/**
 * Class CachedProductRepositoryTest contains tests for the Wambo\Catalog\CachedProductRepository class.
 */
class CachedProductRepositoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function getProducts_ItemIsNotPresentInCache_ResultComesFromUnderlyingRepository()
    {
        // arrange
        $productRepository = $this->getMockBuilder(ProductRepository::class)->disableOriginalConstructor()->getMock();
        $productRepository->method("getProducts")->willReturn(array(
            new Product(new SKU("a-product"), new Slug("a-product"), new Content("A Product", "A fancy product"))
        ));

        $cache = $this->getMockBuilder(CacheItemPoolInterface::class)->getMock();
        $cache->method("hasItem")->willReturn(false);
        $cache->method("getItem")->willReturn(new \Stash\Item());

        /** @var $cache CacheItemPoolInterface */
        /** @var $productRepository ProductRepository */
        $cachedProductRepository = new CachedProductRepository($cache, $productRepository);

        // act
        $result = $cachedProductRepository->getProducts();

        // assert
        $this->assertCount(1, $result,
            "getProduct should have returned one product from the underlying product repository");
    }

    /**
     * @test
     */
    public function getProducts_ItemIsPresentInCache_ResultIsReturnedFromCache()
    {
        // arrange
        $productRepository = $this->getMockBuilder(ProductRepository::class)->disableOriginalConstructor()->getMock();

        $products = array(
            new Product(new SKU("a-product"), new Slug("a-product"), new Content("A Product", "A fancy product"))
        );
        $cacheItemMock = $this->createMock(\Psr\Cache\CacheItemInterface::class);
        $cacheItemMock->method("get")->willReturn($products);


        $cache = $this->getMockBuilder(CacheItemPoolInterface::class)->getMock();
        $cache->method("hasItem")->willReturn(true);
        $cache->method("getItem")->willReturn($cacheItemMock);

        /** @var $cache CacheItemPoolInterface */
        /** @var $productRepository ProductRepository */
        $cachedProductRepository = new CachedProductRepository($cache, $productRepository);

        // act
        $result = $cachedProductRepository->getProducts();

        // assert
        $this->assertCount(1, $result,
            "getProduct should have returned one product from the cache");
    }
}
