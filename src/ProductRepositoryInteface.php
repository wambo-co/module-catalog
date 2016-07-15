<?php
/**
 * Created by PhpStorm.
 * User: andyk
 * Date: 14/07/16
 * Time: 21:34
 */
namespace Wambo\Catalog;

use Wambo\Catalog\Exception\RepositoryException;
use Wambo\Catalog\Model\Product;


/**
 * The ProductRepositoryInteface interface provides function for reading and writing Products from and to a storage.
 *
 * @package Wambo\Catalog
 */
interface ProductRepositoryInteface
{
    /**
     * Get all products
     *
     * @return Product[]
     *
     * @throws RepositoryException If fetching the products failed
     */
    public function getProducts();

    public function getById(string $id);

    public function add(Product $product);

    public function remove(Product $product);
}