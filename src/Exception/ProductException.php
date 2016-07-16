<?php
namespace Wambo\Catalog\Exception;

/**
 * Class ProductException handles product-related errors.
 *
 * @package Wambo\Catalog
 */
class ProductException extends \Exception
{
    /**
     * ProductException constructor.
     *
     * @param string     $message        An error message
     * @param \Exception $innerException The underlying exception (optional)
     */
    public function __construct($message, $innerException = null)
    {
        parent::__construct($message, 500, $innerException);
    }
}