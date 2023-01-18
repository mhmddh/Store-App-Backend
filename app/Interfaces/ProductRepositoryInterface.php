<?php

namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function getPaginatedProducts($limit, $page, $param, $order);
    public function getProductById($productId);
    public function updateProduct($productId, array $newDetails);
    public function createProduct(array $details);
    public function deleteProduct($productId);
    public function searchProduct($key, $value, $limit, $page,$param,$order);
    public function getClientProducts($clientID);


}
