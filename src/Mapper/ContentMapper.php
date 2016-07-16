<?php
namespace Wambo\Catalog\Mapper;

use Wambo\Catalog\Exception\ContentException;
use Wambo\Catalog\Model\Content;

/**
 * Class ContentMapper creates \Wambo\Model\Content models from data bags with product content data.
 *
 * @package Wambo\Mapper
 */
class ContentMapper
{
    const FIELD_TITLE = "title";
    const FIELD_SUMMARY = "summary";
    const FIELD_DESCRIPTION = "description";

    /**
     * @var array $mandatoryFields A list of all mandatory fields of a Content
     */
    private $mandatoryFields = [self::FIELD_TITLE, self::FIELD_SUMMARY];

    /**
     * Creates a new ContentMapper instance
     */
    public function __construct()
    {
    }

    /**
     * Get a Content model from an array of unstructured product content data
     *
     * @param array $contentData An array containing content attributes
     *
     * @return Content
     *
     * @throws ContentException If a mandatory field is missing
     * @throws ContentException If the no Content could be created from the given product data
     */
    public function getContent(array $contentData)
    {
        // check if all mandatory fields are present
        foreach ($this->mandatoryFields as $mandatoryField) {
            if (!array_key_exists($mandatoryField, $contentData)) {
                throw new ContentException("The field '$mandatoryField' is missing in the given content data");
            }
        }

        // try to create a content model from the available data
        try {

            // title
            $title = "";
            if (isset($contentData[self::FIELD_TITLE])) {
                $title = $contentData[self::FIELD_TITLE];
            }

            // summary
            $summary = "";
            if (isset($contentData[self::FIELD_SUMMARY])) {
                $summary = $contentData[self::FIELD_SUMMARY];
            }

            // description
            $description = "";
            if (isset($contentData[self::FIELD_DESCRIPTION])) {
                $description = $contentData[self::FIELD_DESCRIPTION];
            }

            $content = new Content($title, $summary, $description);
            return $content;

        } catch (\Exception $contentException) {
            throw new ContentException(sprintf("Failed to create a content model from the given data: %s",
                $contentException->getMessage()), $contentException);
        }
    }
}