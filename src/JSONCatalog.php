<?php

namespace Wambo\Catalog;

/**
 * Class JSONCatalog reads and writes products from and to a JSON file.
 */
class JSONCatalog
{

    /**
     * Creates a new instance of the JSONCatalog class.
     */
    public function __construct()
    {
    }

    /**
     * Returns a list of all products in this catalog
     * 
     * @return Product[] A list of Product models
     */
    public function getAllProducts()
    {
        return array();
    }
}