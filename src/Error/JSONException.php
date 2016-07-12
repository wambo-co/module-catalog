<?php
namespace Wambo\Catalog\Error;

/**
 * Class JSONException handles JSON-related errors.
 *
 * @package Wambo\Catalog
 */
class JSONException extends \Exception
{
    /**
     * JSONException constructor.
     *
     * @param string     $message        An error message
     * @param \Exception $innerException The underlying exception (optional)
     */
    public function __construct($message, $innerException = null)
    {
        parent::__construct($message, 500, $innerException);
    }
}