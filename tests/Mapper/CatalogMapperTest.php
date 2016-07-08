<?php

use Wambo\Catalog\Mapper\CatalogMapper;

/**
 * Class CatalogMapperTest contains tests for the CatalogMapper class.
 */
class CatalogMapperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function getCatalog_NullIsGiven_InvalidArgumentExceptionIsThrown()
    {
        // arrange
        $catalogData = null;
        $productMapper = new CatalogMapper();

        // act
        $productMapper->getCatalog($catalogData);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function getCatalog_stdClassIsGiven_InvalidArgumentExceptionIsThrown()
    {
        // arrange
        $catalogData = new stdClass();
        $productMapper = new CatalogMapper();

        // act
        $productMapper->getCatalog($catalogData);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function getCatalog_StringIsGiven_InvalidArgumentExceptionIsThrown()
    {
        // arrange
        $catalogData = "";
        $productMapper = new CatalogMapper();

        // act
        $productMapper->getCatalog($catalogData);
    }

    /**
     * @test
     */
    public function getCatalog_EmptyArrayIsGiven_EmptyCatalogIsReturned()
    {
        // arrange
        $catalogData = array();
        $productMapper = new CatalogMapper();

        // act
        $result =  $productMapper->getCatalog($catalogData);

        // assert
        $this->assertNotNull($result);
    }
}