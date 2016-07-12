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
     * @param Content $content A product content model
     *
     */
    public function __construct(SKU $sku, Slug $slug, Content $content)
    {
        $this->sku = $sku;
        $this->slug = $slug;
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
        return $this->content->getTitle();
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