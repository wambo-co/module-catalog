<?php
use Wambo\Catalog\Model\SKU;

/**
 * Class SKUTest contains tests for the Wambo\Catalog\Model\SKU class.
 */
class SKUTest extends PHPUnit_Framework_TestCase
{
    /**
     * If the given SKU is valid validateSKU should not throw an exception
     *
     * @test
     * @dataProvider getValidSKUs
     *
     * @param string $sku A SKU
     */
    public function validateSKU_validSKUs_NoExceptionIsThrown($sku)
    {
        // act
        try {

            new SKU($sku);
            $exceptionThrown = false;

        } catch (Exception $validationException) {
            $exceptionThrown = true;
        }

        // assert
        $this->assertFalse($exceptionThrown, "validateSKU('$sku') should not have thrown an exception");
    }

    /**
     * If the given SKU is invalid validateSKU should throw an exception
     *
     * @test
     * @dataProvider getInvalidSKUs
     *
     * @param string $sku                      A SKU
     * @param string $expectedExceptionMessage The expected exception message
     */
    public function validateSKU_invalidSKUs_ExceptionIsThrown($sku, $expectedExceptionMessage)
    {
        // act
        try {

            new SKU($sku);
            $exceptionThrown = false;

        } catch (Exception $validationException) {

            // assert
            $exceptionThrown = true;
            $this->assertContains($expectedExceptionMessage, $validationException->getMessage(),
                "validateSKU('$sku') should have thrown an exception with the message: $expectedExceptionMessage");

        }

        // assert
        $this->assertTrue($exceptionThrown, "validateSKU('$sku') should have thrown an exception");
    }

    /**
     * Get a list of valid SKUs
     *
     * @return array
     */
    public static function getValidSKUs()
    {
        return [
            ["abcdefghijklmnopqrstuvwxyz012345"], // max length <= 32
            ["abcdefghijklmnopqrstuvwxyz"], // the whole alphabet
            ["123456789"], // only digits
            ["00000111111111"], // leading zeros
            ["a-product"], // dashes
            ["product1"], // characters and digits
            ["product112345678"], // characters and digits
            ["product-1"],
            ["product-112345678"],
            ["ab"], // min length >= 2
            ["12"], // min length >= 2
        ];
    }

    /**
     * Get a list of invalid SKUs
     *
     * @return array
     */
    public static function getInvalidSKUs()
    {
        // format: [ "sku", "expected exception messages" ]
        return [
            // empty
            ["", "empty"],

            // white space
            [" product", "white space"],
            ["product ", "white space"],
            [" product ", "white space"],
            ["pro duct", "white space"],

            // invalid characters
            ['7$tshirt', "invalid characters"], // Dollar sign
            ['gâteau', "invalid characters"], // French umlaut
            ['käse', "invalid characters"], // German umlaut
            ['product/1', "invalid characters"],
            ['product:1', "invalid characters"],
            ['product.1', "invalid characters"],
            ['product(1)', "invalid characters"],
            ['product§1', "invalid characters"],
            ['👃-spray', "invalid characters"], // nose emoji
            ['Åre', "invalid characters"], // Swedish umlaut
            ['Öresund', "invalid characters"], // German umlaut
            ['наушник', "invalid characters"], // Russian
            ['이어폰', "invalid characters"], // Korean

            // invalid prefix
            ['-product', "cannot start"],


            // invalid postfix
            ['product-', "cannot end"],

            // uppercase characters
            ["Product-123", "uppercase"],
            ["pro-Duct-123", "uppercase"],
            ["AAA", "uppercase"],
            ["aBc", "uppercase"],
            ["abC", "uppercase"],
            ["abC", "uppercase"],

            // minimum length
            ["a", "too short"],
            ["1", "too short"],
            ["0", "too short"],

            // maximum length
            ["abcdefghijklmnopqrstuvwxyz0123456789", "too long"],

        ];
    }
}
