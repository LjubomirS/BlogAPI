<?php

namespace Module4Project\Repository;

use Module4Project\Entity\Category;

interface CategoryRepository
{
    public function store(Category $category): void;
    /**
     * @return Category[]
     */
    public function read(mixed $args): array;
    /**
     * @return Category[]
     */
    public function getAllCategories(): array;
    public function update(mixed $inputs, mixed $args): void;
    public function delete(mixed $args): void;
}
