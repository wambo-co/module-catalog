<?php
use League\Flysystem\Filesystem;
use League\Flysystem\Memory\MemoryAdapter;
use Wambo\Catalog\CatalogFactory;

/**
 * Class CatalogFactoryTest tests the Wambo\Catalog\CatalogFactory class.
 */
class CatalogFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function getCatalog_IntegrationTest_CatalogJSONIsValid_CatalogIsReturned()
    {
        // arrange
        $catalogFilePath = "catalog.json";
        $filesystem = new Filesystem(new MemoryAdapter());
        $catalogJSON = <<<JSON
[]
JSON;
        $filesystem->write($catalogFilePath, $catalogJSON);

        $catalogFactory = new CatalogFactory($filesystem, $catalogFilePath);

        // act
        $catalog = $catalogFactory->getCatalog();

        // assert
        $this->assertNotNull($catalog, "The catalog should not be null");
    }

    /**
     * @test
     * @expectedException Wambo\Catalog\Error\CatalogException
     */
    public function getCatalog_IntegrationTest_CatalogJSONIsInvalid_CatalogExceptionIsThrown()
    {
        // arrange
        $catalogFilePath = "catalog.json";
        $filesystem = new Filesystem(new MemoryAdapter());
        $catalogJSON = <<<JSON
[
    {
        "sku": ""
    }
]
JSON;
        $filesystem->write($catalogFilePath, $catalogJSON);

        $catalogFactory = new CatalogFactory($filesystem, $catalogFilePath);

        // act
        $catalogFactory->getCatalog();
    }
}
