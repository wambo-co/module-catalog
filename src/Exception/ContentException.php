<?php
namespace Wambo\Catalog\Exception;

/**
 * Class ContentException handles product-related errors.
 *
 * @package Wambo\Catalog
 */
class ContentException extends \Exception
{
    /**
     * ContentException constructor.
     *
     * @param string     $message        An error message
     * @param \Exception $innerException The underlying exception (optional)
     */
    public function __construct($message, $innerException = null)
    {
        parent::__construct($message, 500, $innerException);
    }
}