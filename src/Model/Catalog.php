<?php

namespace Wambo\Catalog\Model;

/**
 * Class Catalog contains a list of Product models
 *
 * @package Wambo\Catalog\Model
 */
class Catalog implements \Countable
{
    /**
     * @var Product[]
     */
    private $products;

    /**
     * Creates a new Catalog instance from the given Product models
     *
     * @param Product[] $products A list of Product models
     */
    public function __construct(array $products)
    {
        $this->products = $products;
    }

    /**
     * Get a list of all Product models in this catalog
     *
     * @return Product[]
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Get the number of products in this catalog
     *
     * @see \Countable
     *
     * @return integer
     */
    public function count()
    {
        return count($this->products);
    }
}