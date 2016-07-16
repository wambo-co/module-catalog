<?php

use Wambo\Catalog\Model\Content;

/**
 * Class ContentTests tests the Wambo\Catalog\Model\Content class.
 */
class ContentTests extends PHPUnit_Framework_TestCase
{
    /**
     * If the given content data is valid a Content model with the given title, summary and description
     * should be returned
     *
     * @test
     * @dataProvider getValidContentData
     *
     * @param string $title
     * @param string $summary
     * @param string $description
     */
    public function getContent_ValidContentGiven_ContentIsReturned(
        $title,
        $summary,
        $description
    ) {
        // act
        $content = new Content($title, $summary, $description);

        // assert
        $this->assertNotEmpty($content->getTitle(), "The title of the content model should not be empty");
        $this->assertNotEmpty($content->getSummaryText(), "The summary of the content model should not be empty");
        $this->assertNotEmpty($content->getProductDescription(),
            "The description of the content model should not be empty");
    }

    /**
     * If the given content data is invalid a ContentException should be thrown
     *
     * @test
     * @dataProvider                   getContentWithInvalidAttributes
     * @expectedException Wambo\Catalog\Exception\ContentException
     * @expectedExceptionMessageRegExp /The (title|summary text) should not be (shorter|longer) than \d+ characters/
     *
     * @param string $title
     * @param string $summary
     * @param string $description
     */
    public function getContent_InvalidAttributes_ContentExceptionIsThrown($title, $summary, $description)
    {
        // act
        new Content($title, $summary, $description);
    }

    /**
     * Get a list of valid content data for testing
     *
     * @return array
     */
    public static function getValidContentData()
    {
        return array(

            // normal content
            [
                "A title",
                "A product summary",
                "A detailed product description"
            ],

            // empty description
            [
                "A title",
                "A product summary",
                "A detailed product description ..."
            ],

            // long title and summary
            [
                "A looooooooooooooooooooooooooooooooooooooooooooooooong title",
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
    public static function getContentWithInvalidAttributes()
    {
        return array(
            // title empty
            ["", "Summary", "Description..."],

            // title too long
            [
                "ABCdefghijklmnopqrstuvwxyzöüä.ABCdefghijklmnopqrstuvwxyzöüä.ABCdefghijklmnopqrstuvwxyzöüä.",
                "Summary",
                "Description..."
            ],

            // summary empty
            ["A title", "", ""],

            // summary too short
            ["A title", "abc", ""],

            // summary too long
            [
                "A title",
                "ABCdefghijklmnopqrstuvwxyzöüä.ABCdefghijklmnopqrstuvwxyzöüä.ABCdefghijklmnopqrstuvwxyzöüä.ABCdefghijklmnopqrstuvwxyzöüä.ABCdefghijklmnopqrstuvwxyzöüä.",
                ""
            ]
        );
    }
}
