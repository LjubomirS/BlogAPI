<?php

namespace Module4Project\Repository;

use Module4Project\Entity\Category;
use PDO;

class CategoryRepositoryFromPdo implements CategoryRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    private function storeQuery(): string
    {
        return <<<SQL
            INSERT INTO categories (category_id, name, description)
            VALUES (:category_id, :name, :description)
        SQL;
    }

    private function updateQuery(): string
    {
        return <<<SQL
            UPDATE categories
            SET name = :name, description = :description
            WHERE category_id = :category_id
        SQL;
    }

    public function store(Category $category): void
    {
        $sql = $this->storeQuery();
        $stm = $this->pdo->prepare($sql);

        $params = [
            ':category_id' => $category->categoryId(),
            ':name' => $category->name(),
            ':description' => $category->description()
        ];

        $stm->execute($params);
    }

    /**
     * @return Category[]
     */
    public function read(mixed $args): array
    {
        $stm = $this->pdo->prepare('SELECT * FROM categories WHERE category_id = :category_id');
        $stm->bindParam(':category_id', $args['id']);
        $stm->execute();

        $category = $stm->fetch(\PDO::FETCH_ASSOC);

        if (!$category) {
            return [];
        }

        return $category;
    }

    /**
     * @return Category[]
     */
    public function getAllCategories(): array
    {
        $stm = $this->pdo->prepare('SELECT * FROM categories');
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function update(mixed $inputs, mixed $args): void
    {
        $sql = $this->updateQuery();
        $stm = $this->pdo->prepare($sql);

        $params = [
            ':category_id' => $args['id'],
            ':name' => $inputs['name'],
            ':description' => $inputs['description']
        ];

        $stm->execute($params);
    }

    public function delete(mixed $args): void
    {
        $stm = $this->pdo->prepare('DELETE FROM categories WHERE category_id = :category_id');
        $stm->bindParam(':category_id', $args['id']);
        $stm->execute();
    }
}
