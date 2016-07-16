<?php

namespace Wambo\Catalog\Model;

use Wambo\Catalog\Exception\SlugException;

/**
 * Class Slug represents a human-readable, descriptive URL fragment for the product (e.g.
 * "fancy-t-shirt-1-with-ice-cream-pooping-unicorn")
 *
 * @package Wambo\Catalog\Model
 */
class Slug
{
    /**
     * @var string $whiteSpacePattern A regular expression that matches white-space characters
     */
    private $whiteSpacePattern = '/[\s]/';

    /**
     * @var string $invalidCharactersPattern A regular expression that matches all characters that are invalid for a
     *      Slug
     */
    private $invalidCharactersPattern = '/[^\p{L}\w-_:.,+]/u';

    /**
     * @var int $minLength Defines the minimum length for a Slug
     */
    private $minLength = 2;

    /**
     * @var int $maxLength Defines the maximum length of a Slug
     */
    private $maxLength = 64;
    /**
     * @var string
     */
    private $slug;

    /**
     * Create a new SlugValidator instance.
     *
     * @param string $slug  human-readable, descriptive URL fragment for the product (e.g.
     *                      "fancy-t-shirt-1-with-ice-cream-pooping-unicorn")
     *
     * @throws SlugException If the given $slug is invalid
     */
    public function __construct(string $slug)
    {
        $this->validateSlug($slug);
        $this->slug = $slug;
    }

    /**
     * Get a string representation of the current Slug.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->slug;
    }

    /**
     * Validate the given Slug
     *
     * @param string $sku A unique identifier for a product (e.g. "fancy-short-1")
     *
     * @return void
     *
     * @throws SlugException If the given $sku is invalid
     */
    private function validateSlug(string $sku)
    {
        if (strlen($sku) == 0) {
            throw new SlugException("A Slug cannot be empty");
        }

        // check for white-space
        $containsWhitespace = preg_match($this->whiteSpacePattern, $sku) == 1;
        if ($containsWhitespace) {
            throw new SlugException(sprintf("A Slug cannot contain white space characters: \"%s\"", $sku));
        }

        // check for invalid characters
        $containsInvalidCharacters = preg_match($this->invalidCharactersPattern, $sku) == 1;
        if ($containsInvalidCharacters) {
            throw new SlugException(sprintf("The Slug \"%s\" contains invalid characters. A Slug can only contain the following characters: a-z, 0-9 and -",
                $sku));
        }

        // check minimum length
        if (strlen($sku) < $this->minLength) {
            throw new SlugException(sprintf("The given Slug \"%s\" is too short. The minimum length for a Slug is: %s",
                $sku, $this->minLength));
        }

        // check maximum length
        if (strlen($sku) > $this->maxLength) {
            throw new SlugException(sprintf("The given Slug \"%s\" is too long (%s character). The maximum length for a Slug is: %s",
                strlen($sku), $sku, $this->maxLength));
        }
    }

}