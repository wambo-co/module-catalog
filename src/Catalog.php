<?php

namespace Wambo\Catalog;

use Wambo\Core\App;
use Wambo\Core\Module\ModuleBootstrapInterface;


/**
 * Class Catalog is a dummy class to get the catalog module to work in the demo store.
 * TODO: Remove this class once the module installer no longer requires this class for every module.
 *
 * @package Wambo\Catalog
 */
class Catalog implements ModuleBootstrapInterface
{
    /**
     * @param App $app
     */
    public function __construct(App $app)
    {
    }
}