<?php
namespace Wambo\Catalog\Exception;

/**
 * Class CatalogException handles catalog-related errors.
 *
 * @package Wambo\Catalog
 */
class CatalogException extends \Exception
{
    /**
     * CatalogException constructor.
     *
     * @param string     $message        An error message
     * @param \Exception $innerException The underlying exception (optional)
     */
    public function __construct($message, $innerException = null)
    {
        parent::__construct($message, 500, $innerException);
    }
}