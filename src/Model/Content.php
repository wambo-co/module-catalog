<?php
namespace Wambo\Catalog\Model;

use Wambo\Catalog\Error\ContentException;

/**
 * Class Content contains a product title, summary and description text
 *
 * @package Wambo\Catalog\Model
 */
class Content
{
    const TITLE_MIN_LENGTH = 1;
    const TITLE_MAX_LENGTH = 60;

    const SUMMARY_MIN_LENGTH = 5;
    const SUMMARY_MAX_LENGTH = 140;

    /**
     * @var string
     */
    private $summaryText;
    /**
     * @var string
     */
    private $productDescription;
    /**
     * @var string
     */
    private $title;

    /**
     * Creates a new instance of a product Content model.
     *
     * @param string $title              A product title (e.g. "Fancy T-Shirt No. 1")
     * @param string $summaryText        A short description text of a product (e.g. "The first edition of our fancy
     *                                   T-Shirt with a unicorn pooping ice cream on the front"; optional)
     * @param string $productDescription A full product description text (optional)
     *
     * @throws ContentException If the summary text is too long
     */
    public function __construct(string $title, string $summaryText = "", string $productDescription = "")
    {
        // validate the title
        $title = trim($title);
        if (strlen($title) < self::TITLE_MIN_LENGTH) {
            throw new ContentException(sprintf("The title should not be shorter than %s characters",
                self::TITLE_MIN_LENGTH));
        }

        if (strlen($title) > self::TITLE_MAX_LENGTH) {
            throw new ContentException(sprintf("The title should not be longer than %s characters",
                self::TITLE_MAX_LENGTH));
        }

        // validate the summary
        $summaryText = trim($summaryText);

        if (strlen($summaryText) < self::SUMMARY_MIN_LENGTH) {
            throw new ContentException(sprintf("The summary text should not be shorter than %s characters",
                self::SUMMARY_MIN_LENGTH));
        }

        if (strlen($summaryText) > self::SUMMARY_MAX_LENGTH) {
            throw new ContentException(sprintf("The summary text should not be longer than %s characters",
                self::SUMMARY_MAX_LENGTH));
        }

        $this->title = $title;
        $this->summaryText = $summaryText;
        $this->productDescription = $productDescription;
    }

    /**
     * Get the title of a product (e.g. "Fancy T-Shirt No. 1")
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get a short description text of a product (e.g. "The first edition of our fancy T-Shirt with a unicorn pooping
     * ice cream on the front")
     *
     * @return string
     */
    public function getSummaryText()
    {
        return $this->summaryText;
    }

    /**
     * Get a full product description text
     *
     * @return string
     */
    public function getProductDescription()
    {
        return $this->productDescription;
    }
}