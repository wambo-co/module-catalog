# Wambo Catalog

A product catalog module for Wambo

[![Build Status](https://scrutinizer-ci.com/g/wambo-co/module-catalog/badges/build.png?b=develop)](https://scrutinizer-ci.com/g/wambo-co/module-catalog/build-status/develop) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/wambo-co/module-catalog/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/wambo-co/module-catalog/?branch=develop) [![Code Coverage](https://scrutinizer-ci.com/g/wambo-co/module-catalog/badges/coverage.png?b=develop)](https://scrutinizer-ci.com/g/wambo-co/module-catalog/?branch=develop)

Wambo Catalog provides read access to JSON-based product catalogs.

see: [sample-catalog.json](tests/resources/sample-catalog.json)

## Refactoring

Refactoring the structure of the wambo/catalog module.

- Cache (Core): A simple JSON cache that writes objects from and to disc
    - Key/Value
    - Filesystem
    - JSON
- ProductCache (Catalog) implements CacheInterface
    - JSON serialization of Product Models
- JSONDecoder (Core): Converts JSON to arrays
    - getData(string: json): array
- JSONEncoder (Core): Converts arrays to JSON
    - getJSON(array): string
- CachedProductRepository(Cache, ProductRepository) implements ProductRepositoryInterface: Adds a cache layer to the ProductRepository
- ProductRepository(ProductGateway): Fetches Products from the ProductGateway and writes Products back to the ProductGateway
    - getProducts: Product[]
    - getById(string: id)
    - add(Product)
    - remove(Product)
- ProductMapper: Maps Product models from unstructured data and vice versa
     - getProduct(array): Product
     - getData(Product): array
- ProductStorage: Reads and writes unstructured data
    - getProductData: array
    - saveProductData(array)
- Other todos:
    - Rename Error to Exception
    - Remove Catalog Model
    - Remove the existing CatalogFactory

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