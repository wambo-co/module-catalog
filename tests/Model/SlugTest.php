<?php
use Wambo\Catalog\Model\Slug;

/**
 * Class SlugTest tests the Wambo\Catalog\Model\Slug class.
 */
class SlugTest extends PHPUnit_Framework_TestCase
{
    /**
     * If the given Slug is valid validateSlug should not throw an exception
     *
     * @test
     * @dataProvider getValidSlugs
     *
     * @param string $sku A Slug
     */
    public function validateSlug_validSlugs_NoExceptionIsThrown($sku)
    {
        // act
        try {

            new Slug($sku);
            $exceptionThrown = false;

        } catch (Exception $validationException) {
            $exceptionThrown = true;
        }

        // assert
        $this->assertFalse($exceptionThrown, "validateSlug('$sku') should not have thrown an exception");
    }

    /**
     * If the given Slug is invalid validateSlug should throw an exception
     *
     * @test
     * @dataProvider getInvalidSlugs
     *
     * @param string $sku                      A Slug
     * @param string $expectedExceptionMessage The expected exception message
     */
    public function validateSlug_invalidSlugs_ExceptionIsThrown($sku, $expectedExceptionMessage)
    {
        // act
        try {

            new Slug($sku);
            $exceptionThrown = false;

        } catch (Exception $validationException) {

            // assert
            $exceptionThrown = true;
            $this->assertContains($expectedExceptionMessage, $validationException->getMessage(),
                "validateSlug('$sku') should have thrown an exception with the message: $expectedExceptionMessage");

        }

        // assert
        $this->assertTrue($exceptionThrown, "validateSlug('$sku') should have thrown an exception");
    }

    /**
     * Get a list of valid Slugs
     *
     * @return array
     */
    public static function getValidSlugs()
    {
        return [
            ["abcdefghijklmnopqrstuvwxyz012345abcdefghijklmnopqrstuvwxyz012345"], // max length <= 32
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
            ["abc-dfg"],
            ["abc_dfg"],
            ["abc:dfg"],
            ["abc.dfg"],
            ["abc,dfg"],
            ["abc+dfg"],
            ["ABC_xyz"],
            ['Åre'], // Swedish umlaut
            ['Öresund'], // German umlaut
            ['наушник'], // Russian
            ['이어폰'], // Korean
        ];
    }

    /**
     * Get a list of invalid Slugs
     *
     * @return array
     */
    public static function getInvalidSlugs()
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
            ['product(1)', "invalid characters"],
            ['product§1', "invalid characters"],
            ['👃-spray', "invalid characters"], // nose emoji

            // minimum length
            ["a", "too short"],
            ["1", "too short"],
            ["0", "too short"],

            // maximum length
            ["abcdefghijklmnopqrstuvwxyz0123456789abcdefghijklmnopqrstuvwxyz0123456789", "too long"],

        ];
    }
}
