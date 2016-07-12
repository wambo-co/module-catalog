# Wambo Catalog

A product catalog module for Wambo

[![Build Status](https://scrutinizer-ci.com/g/wambo-co/module-catalog/badges/build.png?b=develop)](https://scrutinizer-ci.com/g/wambo-co/module-catalog/build-status/develop) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/wambo-co/module-catalog/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/wambo-co/module-catalog/?branch=develop) [![Code Coverage](https://scrutinizer-ci.com/g/wambo-co/module-catalog/badges/coverage.png?b=develop)](https://scrutinizer-ci.com/g/wambo-co/module-catalog/?branch=develop)

Wambo Catalog provides read access to JSON-based product catalogs.

see: [sample-catalog.json](tests/resources/sample-catalog.json)

## Installation

```bash
composer require wambo/module-catalog
```

## Usage

```php
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

$sampleCatalogFilename = "sample-catalog.json";
$testResourceFolderPath = realpath(__DIR__ . '/tests/resources');
$adapter = new Local($testResourceFolderPath);
$filesystem = new Filesystem($adapter);

$catalogFactory =  new Wambo\Catalog\CatalogFactory($filesystem, $sampleCatalogFilename);
$catalog = $catalogFactory->getCatalog();

foreach ($catalog->getProducts() as $product) {
    /** @var \Wambo\Catalog\Model\Product $product */
    echo $product->getTitle();
}
```