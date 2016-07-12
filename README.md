# Wambo Catalog

A product catalog module for Wambo

[![Build Status](https://scrutinizer-ci.com/g/wambo-co/module-catalog/badges/build.png?b=develop)](https://scrutinizer-ci.com/g/wambo-co/module-catalog/build-status/develop) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/wambo-co/module-catalog/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/wambo-co/module-catalog/?branch=develop) [![Code Coverage](https://scrutinizer-ci.com/g/wambo-co/module-catalog/badges/coverage.png?b=develop)](https://scrutinizer-ci.com/g/wambo-co/module-catalog/?branch=develop)

Wambo Catalog provides read access to JSON-based product catalogs.

## Usage

```php

$filesystem = new Filesystem(new MemoryAdapter());
$contentMapper = new ContentMapper();
$productMapper = new ProductMapper($contentMapper);
$catalogMapper = new CatalogMapper($productMapper);

$filesystem->write("catalog.json", $json);
$jsonCatalogProvider = new JSONCatalogProvider($filesystem, "catalog.json", $catalogMapper);

$catalog = $jsonCatalogProvider->getCatalog();

foreach (
```