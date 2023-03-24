<?php

namespace Module5Project\Repository;

use Module5Project\Entity\Category;

interface CategoryRepository
{
    public function store(Category $category): void;

    public function read(mixed $args): ?Category;
    /**
     * @return Category[]
     */
    public function getAllCategories(): array;
    public function update(mixed $inputs, mixed $args): void;
    public function delete(mixed $args): void;
}
