<?php

namespace Wambo\Catalog\Exception;

/**
 * Class ProductException handles ProductRepository-related errors.
 *
 * @package Wambo\Catalog
 */
class RepositoryException extends \Exception
{
    /**
     * RepositoryException constructor.
     *
     * @param string     $message        An error message
     * @param \Exception $innerException The underlying exception (optional)
     */
    public function __construct($message, $innerException = null)
    {
        parent::__construct($message, 500, $innerException);
    }
}