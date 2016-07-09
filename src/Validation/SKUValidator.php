<?php
namespace Wambo\Catalog\Validation;

use Wambo\Catalog\Error\SKUException;

/**
 * Class SKUValidator validates SKUs
 *
 * @package Wambo\Catalog\Validation
 */
class SKUValidator
{
    /**
     * @var string $whiteSpacePattern A regular expression that matches white-space characters
     */
    private $whiteSpacePattern = '/[\s]/';

    /**
     * @var string $invalidCharactersPattern A regular expression that matches all characters that are invalid for a SKU
     */
    private $invalidCharactersPattern = '/[^a-z0-9-]/';

    /**
     * @var string $uppercaseCharactersPattern A regular expression that matches uppercase characters
     */
    private $uppercaseCharactersPattern = '/[A-Z]/';

    /**
     * @var int $minLength Defines the minimum length for a SKU
     */
    private $minLength = 2;

    /**
     * @var int $maxLength Defines the maximum length of a SKU
     */
    private $maxLength = 32;

    /**
     * Create a new SKUValidator instance.
     */
    public function __construct()
    {
    }

    /**
     * Validate the given SKU
     *
     * @param string $sku A unique identifier for a product (e.g. "fancy-short-1")
     *
     * @return void
     *
     * @throws SKUException If the given $sku is invalid
     */
    public function validateSKU(string $sku)
    {
        if (strlen($sku) == 0) {
            throw new SKUException("A SKU cannot be empty");
        }

        // check for white-space
        $containsWhitespace = preg_match($this->whiteSpacePattern, $sku) == 1;
        if ($containsWhitespace) {
            throw new SKUException(sprintf("A SKU cannot contain white space characters: \"%s\"", $sku));
        }

        // uppercase
        $containsUppercaseCharacters = preg_match($this->uppercaseCharactersPattern, $sku) == 1;
        if ($containsUppercaseCharacters) {
            throw new SKUException(sprintf("A SKU cannot contain uppercase characters: \"%s\"", $sku));
        }

        // check for invalid characters
        $containsInvalidCharacters = preg_match($this->invalidCharactersPattern, $sku) == 1;
        if ($containsInvalidCharacters) {
            throw new SKUException(sprintf("The SKU \"%s\" contains invalid characters. A SKU can only contain the following characters: a-z, 0-9 and -",
                $sku));
        }

        // check minimum length
        if (strlen($sku) < $this->minLength) {
            throw new SKUException(sprintf("The given SKU \"%s\" is too short. The minimum length for a SKU is: %s",
                $sku, $this->minLength));
        }

        // check maximum length
        if (strlen($sku) > $this->maxLength) {
            throw new SKUException(sprintf("The given SKU \"%s\" is too long (%s character). The maximum length for a SKU is: %s",
                strlen($sku), $sku, $this->maxLength));
        }
    }
}