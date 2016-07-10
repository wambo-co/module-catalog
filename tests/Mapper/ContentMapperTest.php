<?php
use Wambo\Catalog\Mapper\ContentMapper;

/**
 * Class ContentMapperTest tests the Wambo\Catalog\Mapper\ContentMapper class.
 */
class ContentMapperTest extends PHPUnit_Framework_TestCase
{
    /**
     * If the given summary and description is valid a Content model with the given summary and description should be
     * returned
     *
     * @test
     * @dataProvider getValidContentData
     *
     * @param array $contentData Product content data
     */
    public function getContent_ValidSummaryAndDescriptionGiven_ContentWithSummaryAndDescriptionIsReturned($contentData)
    {
        // arrange
        $productMapper = new ContentMapper();

        // act
        $content = $productMapper->getContent($contentData);

        // assert
        $this->assertNotEmpty($content->getSummaryText(), "The summary of the content model should not be empty");
        $this->assertNotEmpty($content->getProductDescription(), "The description of the content model should not be empty");
    }

    /**
     * If the given summary and description is valid a Content model with the given summary and description should be
     * returned
     *
     * @test
     * @dataProvider getContentDataWithMissingAttributes
     * @expectedException Wambo\Catalog\Error\ContentException
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
     * If the given summary is invalid a ContentException should be thrown
     *
     * @test
     * @dataProvider getContentWithInvalidSummary
     * @expectedException Wambo\Catalog\Error\ContentException
     * @expectedExceptionMessageRegExp /The summary text should not be (shorter|longer) than \d+ characters/
     *
     * @param array $contentData Product content data
     */
    public function getContent_InvalidSummary_ContentExceptionIsThrown($contentData)
    {
        // arrange
        $productMapper = new ContentMapper();

        // act
        $productMapper->getContent($contentData);
    }

    /**
     * Get a list of valid content data for testing
     * @return array
     */
    public static function getValidContentData() {
        return array(
            [
                [
                    "summary" => "A product summary",
                    "description" => "A detailed product description",
                ],

                [
                    "summary" => "ABCdefghijklmnopqrstuvwxyzöüä.ABCdefghijklmnopqrstuvwxyzöüä.ABCdefghijklmnopqrstuvwxyzöüä.ABCdefghijklmnopqrstuvwxyzöüä.",
                    "description" => "A detailed product description ...",
                ]
            ]
        );
    }

    /**
     * Get a list of valid content data for testing
     * @return array
     */
    public static function getContentWithInvalidSummary() {
        return array(
            [
                // empty
                [
                    "summary" => "",
                ],

                // too short
                [
                    "summary" => "A",
                ],

                // too long
                [
                    "summary" => "ABCdefghijklmnopqrstuvwxyzöüä.ABCdefghijklmnopqrstuvwxyzöüä.ABCdefghijklmnopqrstuvwxyzöüä.ABCdefghijklmnopqrstuvwxyzöüä.ABCdefghijklmnopqrstuvwxyzöüä.",
                ]
            ]
        );
    }

    /**
     * Get a list of content data object with missing attribtues for testing
     * @return array
     */
    public static function getContentDataWithMissingAttributes() {
        return array(
            [
                // wrong casing
                [
                    "SUMMARY" => "A product summary",
                    "description" => "A detailed product description",
                ],

                // summary missing
                [
                    "description" => "A detailed product description",
                ]
            ]
        );
    }
}
