<?php

namespace App\Interfaces;
use Illuminate\Http\Request;

interface CategoryRepositoryInterface
{
    public function getPaginatedCategories($limit, $page, $param, $order);
    public function getAllCategories();
    public function getCategoryById($categoryId);
    public function updateCategory($categoryId, array $newDetails);
    public function createCategory(array $details);
    public function deleteCategory($categoryId);
    public function searchCategory($key, $value, $limit, $page,$param,$order);
}
