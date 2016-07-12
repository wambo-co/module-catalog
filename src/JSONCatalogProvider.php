<?php

namespace Wambo\Catalog;

use League\Flysystem\FilesystemInterface;
use Wambo\Catalog\Error\CatalogException;
use Wambo\Catalog\Error\JSONException;
use Wambo\Catalog\Mapper\CatalogMapper;
use Wambo\Catalog\Model\Catalog;

/**
 * Class JSONCatalogProvider reads product and catalog data from an JSON file.
 */
class JSONCatalogProvider implements CatalogProviderInterface
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
     * @var CatalogMapper A catalog mapper for converting unstructured catalog data into Catalog models
     */
    private $catalogMapper;

    /**
     * Creates a new instance of the JSONCatalogProvider class.
     *
     * @param FilesystemInterface $filesystem      The filesystem this Catalog instance works on
     * @param string              $catalogFilePath The path to the JSON file containing the catalog in the given
     *                                             $filesystem
     *
     * @param CatalogMapper       $catalogMapper   A catalog mapper for converting unstructured catalog data into
     *                                             Catalog models
     */
    public function __construct(FilesystemInterface $filesystem, string $catalogFilePath, CatalogMapper $catalogMapper)
    {
        $this->filesystem = $filesystem;
        $this->catalogFilePath = $catalogFilePath;
        $this->catalogMapper = $catalogMapper;
    }

    /**
     * Get the product catalog.
     *
     * @return Catalog
     *
     * @throws CatalogException If the catalog could not be created.
     */
    public function getCatalog()
    {
        if ($this->filesystem->has($this->catalogFilePath) == false) {
            return array();
        }

        try {

            $json = $this->filesystem->read($this->catalogFilePath);
            $catalogData = $this->parseJSON($json);

            // convert the catalog data into a Catalog model
            $catalog = $this->catalogMapper->getCatalog($catalogData);

            return $catalog;

        } catch (\Exception $catalogException) {
            throw new CatalogException(sprintf("Unable to read catalog from %s: ", $this->catalogFilePath,
                $catalogException->getMessage()), $catalogException);
        }
    }

    /**
     * Parse the given JSON and convert it into an array.
     *
     * @param string $json JSON code
     *
     * @return array
     *
     * @throws JSONException If the given JSON could not be parsed
     */
    private function parseJSON($json)
    {
        $catalogData = json_decode($json, true);

        // handle errors
        switch (json_last_error()) {

            case JSON_ERROR_DEPTH:
                throw new JSONException("The maximum stack depth has been exceeded");

            case JSON_ERROR_STATE_MISMATCH:
                throw new JSONException("Invalid or malformed JSON");

            case JSON_ERROR_CTRL_CHAR:
                throw new JSONException("Control character error, possibly incorrectly encoded");

            case JSON_ERROR_SYNTAX:
                throw new JSONException("Syntax error");

            case JSON_ERROR_UTF8:
                throw new JSONException("Malformed UTF-8 characters, possibly incorrectly encoded");

        }

        return $catalogData;
    }
}