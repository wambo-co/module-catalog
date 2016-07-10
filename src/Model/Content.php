<?php
namespace Wambo\Catalog\Model;

/**
 * Class Content contains the product summary and description text
 *
 * @package Wambo\Catalog\Model
 */
class Content
{
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
     */
    public function __construct(string $summaryText = "", string $productDescription = "")
    {
        $this->summaryText = $summaryText;
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