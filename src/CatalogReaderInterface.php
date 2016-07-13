<?php
namespace Wambo\Catalog;

use Wambo\Catalog\Model\Catalog;

/**
 * Class JSONCatalogProvider returns product and catalog data.
 */
interface CatalogReaderInterface
{
    /**
     * Get the product catalog.
     *
     * @return Catalog
     */
    public function getCatalog();
}