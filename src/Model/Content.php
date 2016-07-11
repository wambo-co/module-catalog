<?php
namespace Wambo\Catalog\Model;

/**
 * Class Content contains the product summary and description text
 *
 * @package Wambo\Catalog\Model
 */
class Content
{
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
     * Creates a new instance of the product Content model.
     *
     * @param string $summaryText        A short description text of the product (e.g. "The first edition of our fancy
     *                                   T-Shirt with a unicorn pooping ice cream on the front"; optional)
     * @param string $productDescription A full product description text (optional)
     *
     * @throws \InvalidArgumentException If the summary text is too short
     * @throws \InvalidArgumentException If the summary text is too long
     */
    public function __construct(string $summaryText = "", string $productDescription = "")
    {
        // trim the summary
        $summaryText = trim($summaryText);

        if (strlen($summaryText) < self::SUMMARY_MIN_LENGTH) {
            throw new \InvalidArgumentException(sprintf("The summary text should not be shorter than %s characters", self::SUMMARY_MIN_LENGTH));
        }

        if (strlen($summaryText) > self::SUMMARY_MAX_LENGTH) {
            throw new \InvalidArgumentException(sprintf("The summary text should not be longer than %s characters", self::SUMMARY_MAX_LENGTH));
        }

        $this->summaryText = trim($summaryText);
        $this->productDescription = $productDescription;
    }

    /**
     * Get a short description text of the product (e.g. "The first edition of our fancy T-Shirt with a unicorn pooping
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