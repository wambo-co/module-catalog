# Wambo Catalog

A product catalog module for Wambo

[![Build Status](https://scrutinizer-ci.com/g/wambo-co/module-catalog/badges/build.png?b=develop)](https://scrutinizer-ci.com/g/wambo-co/module-catalog/build-status/develop) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/wambo-co/module-catalog/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/wambo-co/module-catalog/?branch=develop) [![Code Coverage](https://scrutinizer-ci.com/g/wambo-co/module-catalog/badges/coverage.png?b=develop)](https://scrutinizer-ci.com/g/wambo-co/module-catalog/?branch=develop)

Wambo Catalog provides read access to JSON-based product catalogs.

see: [sample-catalog.json](examples/catalog/sample-catalog.json)

## Installation

```bash
composer require wambo/module-catalog
```

## Usage

see: [examples/usage.php](examples/usage.php)

```php
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
```