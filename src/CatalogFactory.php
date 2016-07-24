<?php

namespace Wambo\Catalog;

use League\Flysystem\FilesystemInterface;
use Wambo\Catalog\Exception\CatalogException;
use Wambo\Catalog\Mapper\CatalogMapper;
use Wambo\Catalog\Mapper\ContentMapper;
use Wambo\Catalog\Mapper\ProductMapper;
use Wambo\Catalog\Model\Catalog;

/**
 * Class CatalogFactory creates Catalog models
 *
 * @package Wambo\Catalog
 */
class CatalogFactory
{
    /** @var CatalogProviderInterface $catalogProvider */
    private $catalogProvider;

    /**
     * CatalogFactory constructor.
     *
     * @param FilesystemInterface $filesystem
     * @param string              $jsonCatalogFilePath The path to the JSON catalog
     */
    public function __construct(FilesystemInterface $filesystem, string $jsonCatalogFilePath)
    {
        $contentMapper = new ContentMapper();
        $productMapper = new ProductMapper($contentMapper);
        $catalogMapper = new CatalogMapper($productMapper);

        $this->catalogProvider = new JSONCatalogProvider($filesystem, $jsonCatalogFilePath, $catalogMapper);
    }

    /**
     * Get the product catalog
     *
     * @return Catalog
     *
     * @throws CatalogException
     */
    public function getCatalog()
    {
        return $this->catalogProvider->getCatalog();
    }
}