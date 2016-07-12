<?php
use Wambo\Catalog\Mapper\ContentMapper;
use Wambo\Catalog\Mapper\ProductMapper;
use Wambo\Catalog\Model\Content;

/**
 * Class ProductMapperTest tests the Wambo\Catalog\Mapper\ProductMapper class.
 */
class ProductMapperTest extends PHPUnit_Framework_TestCase
{
    /**
     * If all required fields are given and the validation passes a product should be returned
     *
     * @test
     */
    public function getProduct_AllRequiredFieldsPresent_ValidationPasses_ProductIsReturned()
    {
        // arrange
        $contentMapperMock = $this->createMock(ContentMapper::class);
        $contentMapperMock->method("getContent")->willReturn(new Content("Title", "Summary", "..."));

        /** @var ContentMapper $contentMapperMock */
        $productMapper = new ProductMapper($contentMapperMock);

        $productData = array(
            "sku" => "a-product",
            "slug" => "A-Product",
            "title" => "Super fancy product",
            "summary" => "A super fancy product",
        );

        // act
        $product = $productMapper->getProduct($productData);

        // assert
        $this->assertNotNull($product, "getProduct() should have returned a product");
    }

    /**
     * If given product data is missing one of the mandatory fields and exception should be thrown.
     *
     * @param array $productData Unstructured product data
     *
     * @test
     *
     * @expectedException \Wambo\Catalog\Error\ProductException
     * @expectedExceptionMessageRegExp /The field '\w+' is missing in the given product data/
     * @dataProvider                   getProductDataWithMissingAttribute
     */
    public function getProduct_RequiredFieldMissing_ProductExceptionIsThrown(array $productData)
    {
        // arrange
        $contentMapperMock = $this->createMock(ContentMapper::class);
        $contentMapperMock->method("getContent")->willReturn(new Content("Title", "Summary", "Description"));

        /** @var ContentMapper $contentMapperMock */
        $productMapper = new ProductMapper($contentMapperMock);

        // act
        $productMapper->getProduct($productData);
    }

    /**
     * If the SKU validation fails and exception should be thrown
     *
     * @test
     * @expectedException Wambo\Catalog\Error\ProductException
     */
    public function getProduct_AllRequiredFieldsPresent_SkuValidationFails_ProductIsReturned()
    {
        // arrange
        $contentMapperMock = $this->createMock(ContentMapper::class);
        $contentMapperMock->method("getContent")->willReturn(new Content("Title", "Summary", "..."));

        /** @var ContentMapper $contentMapperMock */
        $productMapper = new ProductMapper($contentMapperMock);

        $productData = array(
            "sku" => "a",
            "slug" => "A-Product",
            "title" => "Super fancy product",
            "summary" => "A super fancy product",
        );

        // act
        $productMapper->getProduct($productData);
    }

    /**
     * If the Slug validation fails and exception should be thrown
     *
     * @test
     * @expectedException Wambo\Catalog\Error\ProductException
     */
    public function getProduct_AllRequiredFieldsPresent_SlugValidationFails_ProductIsReturned()
    {
        // arrange
        $contentMapperMock = $this->createMock(ContentMapper::class);
        $contentMapperMock->method("getContent")->willReturn(new Content("Title", "A super fancy product", "..."));

        /** @var ContentMapper $contentMapperMock */
        $productMapper = new ProductMapper($contentMapperMock);

        $productData = array(
            "sku" => "a-product",
            "slug" => "A/Product",
            "title" => "Super fancy product",
            "summary" => "A super fancy product",
        );

        // act
        $productMapper->getProduct($productData);
    }

    /**
     * Get product data with one or more missing attributes.
     */
    public static function getProductDataWithMissingAttribute()
    {
        return [

            // empty
            [
                []
            ],

            // wrong casing
            [
                [
                    "SKU" => "a-product",
                    "SLUG" => "A-Product",
                ]
            ],

            // slug missing
            [
                [
                    "sku" => "a-product",
                ]
            ],

            // sku missing
            [
                [
                    "slug" => "A-Product",
                ]
            ]

        ];
    }
}
