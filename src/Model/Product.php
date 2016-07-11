<?php

namespace Wambo\Catalog\Model;

/**
 * Class Product represents a single catalog item or product.
 *
 * @package Wambo\Catalog
 */
class Product
{
    /**
     * @var SKU
     */
    private $sku;
    /**
     * @var Slug
     */
    private $slug;
    /**
     * @var string
     */
    private $title;
    /**
     * @var Content
     */
    private $content;

    /**
     * Creates a new Product basic class instance.
     *
     * @param SKU     $sku     A unique identifier for the product (e.g. "fancy-short-1")
     * @param Slug    $slug    A human-readable, descriptive URL fragment for the product (e.g.
     *                         "fancy-t-shirt-1-with-ice-cream-pooping-unicorn")
     * @param string  $title   The title of the product (e.g. "Fancy T-Shirt No. 1")
     * @param Content $content A product content model
     *
     * @throws \InvalidArgumentException If the given $sku is null or empty.
     * @throws \InvalidArgumentException If the given $slug is null or empty.
     * @throws \InvalidArgumentException If the given $title is null or empty.
     */
    public function __construct(SKU $sku, Slug $slug, string $title, Content $content)
    {
        if (strlen($title) == 0) {
            throw new \InvalidArgumentException("The title cannot be empty");
        }

        $this->sku = $sku;
        $this->slug = $slug;
        $this->title = $title;
        $this->content = $content;
    }

    /**
     * Get the unique identifier for the product (e.g. "fancy-short-1")
     *
     * @return SKU
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Get the human-readable, descriptive URL fragment for the product (e.g.
     *                        "fancy-t-shirt-1-with-ice-cream-pooping-unicorn")
     *
     * @return Slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Get the title of the product (e.g. "Fancy T-Shirt No. 1")
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get a short description text of the product (e.g. "The first edition of our fancy T-Shirt with a unicorn pooping
     * ice cream on the front")
     *
     * @return string
     */
    public function getSummaryText()
    {
        return $this->content->getSummaryText();
    }

    /**
     * Get a full product description text
     *
     * @return string
     */
    public function getProductDescription()
    {
        return $this->content->getProductDescription();
    }
}