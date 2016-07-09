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
     * @var string
     */
    private $sku;
    /**
     * @var string
     */
    private $slug;
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $summary;

    /**
     * Get the unique identifier for the product (e.g. "fancy-short-1")
     *
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Creates a new Product basic class instance.
     *
     * @param string $sku     A unique identifier for the product (e.g. "fancy-short-1")
     * @param string $slug    A human-readable, descriptive URL fragment for the product (e.g.
     *                        "fancy-t-shirt-1-with-ice-cream-pooping-unicorn")
     * @param string $title   The title of the product (e.g. "Fancy T-Shirt No. 1")
     * @param string $summary A short description of the product (e.g. "The first edition of our fancy T-Shirt with a
     *                        unicorn pooping ice cream on the front")
     *
     * @throws \InvalidArgumentException If the given $sku is null or empty.
     * @throws \InvalidArgumentException If the given $slug is null or empty.
     * @throws \InvalidArgumentException If the given $title is null or empty.
     */
    public function __construct(string $sku, string $slug, string $title, string $summary)
    {
        if (strlen($sku) == 0) {
            throw new \InvalidArgumentException("The sku cannot be empty");
        }

        if (strlen($slug) == 0) {
            throw new \InvalidArgumentException("The slug cannot be empty");
        }

        if (strlen($title) == 0) {
            throw new \InvalidArgumentException("The title cannot be empty");
        }

        $this->sku = $sku;
        $this->slug = $slug;
        $this->title = $title;
        $this->summary = $summary;
    }

    /**
     * Get the human-readable, descriptive URL fragment for the product (e.g.
     *                        "fancy-t-shirt-1-with-ice-cream-pooping-unicorn")
     *
     * @return string
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
     * Get A short description of the product (e.g. "The first edition of our fancy T-Shirt with a unicorn pooping ice
     * cream on the front")
     *
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }
}