<?php
use Wambo\Catalog\Mapper\ContentMapper;
use Wambo\Catalog\Model\Content;

/**
 * Class ContentTests tests the Wambo\Catalog\Model\Content class.
 */
class ContentTests extends PHPUnit_Framework_TestCase
{
    /**
     * If the given summary and description is valid a Content model with the given summary and description should be
     * returned
     *
     * @test
     * @dataProvider getValidContentData
     *
     * @param string $summary
     * @param string $description
     */
    public function getContent_ValidSummaryAndDescriptionGiven_ContentWithSummaryAndDescriptionIsReturned(
        $summary,
        $description
    ) {
        // act
        $content = new Content($summary, $description);

        // assert
        $this->assertNotEmpty($content->getSummaryText(), "The summary of the content model should not be empty");
        $this->assertNotEmpty($content->getProductDescription(),
            "The description of the content model should not be empty");
    }

    /**
     * If the given summary is invalid a ContentException should be thrown
     *
     * @test
     * @dataProvider                   getContentWithInvalidSummary
     * @expectedException Wambo\Catalog\Error\ContentException
     * @expectedExceptionMessageRegExp /The summary text should not be (shorter|longer) than \d+ characters/
     *
     * @param string $summary
     * @param string $description
     */
    public function getContent_InvalidSummary_ContentExceptionIsThrown($summary, $description)
    {
        // act
        new Content($summary, $description);
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
                "A product summary",
                "A detailed product description"
            ],

            [
                "ABCdefghijklmnopqrstuvwxyzöüä.ABCdefghijklmnopqrstuvwxyzöüä.ABCdefghijklmnopqrstuvwxyzöüä.ABCdefghijklmnopqrstuvwxyzöüä.",
                "A detailed product description ..."
            ]
        );
    }

    /**
     * Get a list of valid content data for testing
     *
     * @return array
     */
    public static function getContentWithInvalidSummary()
    {
        return array(
            // empty
            ["", ""],

            // too short
            ["A", ""],

            // too long
            [
                "ABCdefghijklmnopqrstuvwxyzöüä.ABCdefghijklmnopqrstuvwxyzöüä.ABCdefghijklmnopqrstuvwxyzöüä.ABCdefghijklmnopqrstuvwxyzöüä.ABCdefghijklmnopqrstuvwxyzöüä.",
                ""
            ]
        );
    }
}
