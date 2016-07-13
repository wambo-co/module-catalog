<?php
namespace Wambo\Catalog\Exception;

/**
 * Class SlugException handles Slug-related errors.
 *
 * @package Wambo\Catalog
 */
class SlugException extends \Exception
{
    /**
     * SlugException constructor.
     *
     * @param string     $message        An error message
     * @param \Exception $innerException The underlying exception (optional)
     */
    public function __construct($message, $innerException = null)
    {
        parent::__construct($message, 500, $innerException);
    }
}