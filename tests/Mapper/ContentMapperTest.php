<?php
use Wambo\Catalog\Mapper\ContentMapper;

/**
 * Class ContentMapperTest tests the Wambo\Catalog\Mapper\ContentMapper class.
 */
class ContentMapperTest extends PHPUnit_Framework_TestCase
{
    /**
     * If the given content data is valid a Content model with the given content data should be
     * returned
     *
     * @test
     * @dataProvider getValidContentData
     *
     * @param array $contentData Product content data
     */
    public function getContent_ValidContentDataGiven_ContentWithSummaryAndDescriptionIsReturned($contentData)
    {
        // arrange
        $productMapper = new ContentMapper();

        // act
        $content = $productMapper->getContent($contentData);

        // assert
        $this->assertNotEmpty($content->getSummaryText(), "The summary of the content model should not be empty");
        $this->assertNotEmpty($content->getProductDescription(),
            "The description of the content model should not be empty");
    }

    /**
     * If the given content data is valid a Content model with the given content data should be
     * returned
     *
     * @test
     * @dataProvider                   getContentDataWithMissingAttributes
     * @expectedException Wambo\Catalog\Exception\ContentException
     * @expectedExceptionMessageRegExp /The field '.+' is missing in the given content data/
     *
     * @param array $contentData Product content data
     */
    public function getContent_FieldsMissing_ContentExceptionIsThrown($contentData)
    {
        // arrange
        $productMapper = new ContentMapper();

        // act
        $productMapper->getContent($contentData);
    }

    /**
     * If some of the given attributes are invalid a ContentException should be thrown
     *
     * @test
     * @dataProvider                   getContentWithInvalidAttributes
     * @expectedException Wambo\Catalog\Exception\ContentException
     * @expectedExceptionMessageRegExp /Failed to create a content model from the given data/
     *
     * @param array $contentData Product content data
     */
    public function getContent_InvalidAttributes_ContentExceptionIsThrown($contentData)
    {
        // arrange
        $productMapper = new ContentMapper();

        // act
        $productMapper->getContent($contentData);
    }

    /**
     * Get a list of valid content data for testing
     *
     * @return array
     */
    public static function getValidContentData()
    {
        return array(
            [
                [
                    "title" => "Product Title",
                    "summary" => "A product summary",
                    "description" => "A detailed product description",
                ],

                [
                    "title" => "Product Title",
                    "summary" => "ABCdefghijklmnopqrstuvwxyzöüä.ABCdefghijklmnopqrstuvwxyzöüä.ABCdefghijklmnopqrstuvwxyzöüä.ABCdefghijklmnopqrstuvwxyzöüä.",
                    "description" => "A detailed product description ...",
                ]
            ]
        );
    }

    /**
     * Get a list of content data with invalid attributes for testing
     *
     * @return array
     */
    public static function getContentWithInvalidAttributes()
    {
        return array(
            [
                // title empty or too short
                [
                    "title" => "",
                    "summary" => "Product summary"
                ],

                // title too long
                [
                    "title" => "ABCdefghijklmnopqrstuvwxyzöüä.ABCdefghijklmnopqrstuvwxyzöüä.ABCdefghijklmnopqrstuvwxyzöüä.",
                    "summary" => "Product summary"
                ],

                // summary empty
                [
                    "summary" => "",
                ],

                // summary too short
                [
                    "summary" => "A",
                ],

                // summary too long
                [
                    "summary" => "ABCdefghijklmnopqrstuvwxyzöüä.ABCdefghijklmnopqrstuvwxyzöüä.ABCdefghijklmnopqrstuvwxyzöüä.ABCdefghijklmnopqrstuvwxyzöüä.ABCdefghijklmnopqrstuvwxyzöüä.",
                ]
            ]
        );
    }

    /**
     * Get a list of content data object with missing attributes for testing
     *
     * @return array
     */
    public static function getContentDataWithMissingAttributes()
    {
        return array(
            [
                // title: wrong casing
                [
                    "Title" => "Product title",
                    "summary" => "A product summary",
                    "description" => "A detailed product description",
                ],

                // title: missing
                [
                    "summary" => "A product summary",
                    "description" => "A detailed product description",
                ],

                // summary: wrong casing
                [
                    "title" => "Product title",
                    "SUMMARY" => "A product summary",
                    "description" => "A detailed product description",
                ],

                // summary: missing
                [
                    "title" => "Product title",
                    "description" => "A detailed product description",
                ]
            ]
        );
    }
}
