<?php
/**
 * A basic usage example of for wambo/module-catalog.
 *
 * Read the sample-catalog.json and print the title and SKU of each
 * product in the catalog using a cached product repository.
 */

require_once '../vendor/autoload.php';

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Wambo\Catalog\CachedProductRepository;
use Wambo\Catalog\Mapper\ContentMapper;
use Wambo\Catalog\Mapper\ProductMapper;
use Wambo\Catalog\Model\Product;
use Wambo\Catalog\ProductRepository;
use Wambo\Core\Module\JSONModuleStorage;

// catalog storage
$sampleCatalogFilename = "sample-catalog.json";
$testResourceFolderPath = realpath(__DIR__ . '/catalog');
$localFilesystemAdapter = new Local($testResourceFolderPath);
$filesystem = new Filesystem($localFilesystemAdapter);
$storage = new JSONModuleStorage($filesystem, $sampleCatalogFilename);

// product mapper
$contentMapper = new ContentMapper();
$productMapper = new ProductMapper($contentMapper);

// create the product repository
$productRepository = new ProductRepository($storage, $productMapper);

// create a cached version of the product repository
$cache = new Stash\Pool();
$cachedProductRepository = new CachedProductRepository($cache, $productRepository);

// get the products from the cached repository
$products = $cachedProductRepository->getProducts();

// print the product titles
foreach ($products as $product) {
    /** @var Product $product */
    echo sprintf("%s (SKU: %s)\n", $product->getTitle(), $product->getSku());
}