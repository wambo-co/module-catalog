<?php

namespace Wambo\Catalog;

use League\Flysystem\FilesystemInterface;

/**
 * Class JSONCatalog reads and writes products from and to a JSON file.
 */
class JSONCatalog
{
    /**
     * @var FilesystemInterface $filesystem The filesystem this Catalog instance works on
     */
    private $filesystem;

    /**
     * @var string $catalogFilePath The path to the JSON file containing the catalog in the given $filesystem
     */
    private $catalogFilePath;

    /**
     * Creates a new instance of the JSONCatalog class.
     *
     * @param FilesystemInterface $filesystem      The filesystem this Catalog instance works on
     * @param string     $catalogFilePath The path to the JSON file containing the catalog in the given $filesystem
     *
     * @throws \InvalidArgumentException If no $filesystem was supplied
     * @throws \InvalidArgumentException If the given $catalogFilePath is empty
     */
    public function __construct(FilesystemInterface $filesystem, string $catalogFilePath)
    {
        if (is_null($filesystem)) {
            throw new \InvalidArgumentException("No filesystem supplied");
        }

        if (empty($catalogFilePath)) {
            throw new \InvalidArgumentException("No path to a catalog file supplied");
        }

        $this->filesystem = $filesystem;
        $this->catalogFilePath = $catalogFilePath;
    }

    /**
     * Returns a list of all products in this catalog
     *
     * @return Product[] A list of Product models
     */
    public function getAllProducts()
    {
        if ($this->filesystem->has($this->catalogFilePath) == false)
        {
            return array();
        }

        $json = $this->filesystem->read($this->catalogFilePath);
        $products = json_decode($json, true);
        return $products;
    }
}