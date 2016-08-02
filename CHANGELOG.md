# Change Log
All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased]

### Changed
- Renamed the Wambo\Catalog\Error namespace to Wambo\Catalog\Exception
- Replace the CatalogProvider with a ProductRepository
- Remove the Catalog Model
- Change package type from "wambo-module" to "library"
- Set module-core to bigger then v0.1.0 in composer.json
- Remove Catalog dummy class because ii is not longe required
- Set wambo core version to "*" and minimum-stability to "dev" to support feature branches
- Use the JSONDecoder from wambo/module-core

### Fixed
- Exclude the tests/ folder from Scrutinizer reports
- Fix coding style and security issues reported by Scrutinizer

## [v0.1.0] - 2016-07-12
### Added
- A composer.json, README and LICENSE
- Base implementation of wambo/module-catalog with a read-only JSONCatalogProvider
