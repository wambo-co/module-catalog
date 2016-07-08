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
     * Creates a new Product basic class instance.
     *
     * @param string $sku     A unique identifier for the product (e.g. fancy-short-1)
     * @param string $title   The title of the product (e.g. "Fancy T-Shirt No. 1")
     * @param string $summary A short description of the product (e.g. "The first edition of our fancy T-Shirt with a
     *                        unicorn pooping ice cream on the front")
     * @param string $slug    A human-readable, descriptive URL fragment for the product (e.g.
     *                        "fancy-t-shirt-1-with-ice-cream-pooping-unicorn")
     */
    public function __construct($sku, $title, $summary, $slug)
    {
    }
}