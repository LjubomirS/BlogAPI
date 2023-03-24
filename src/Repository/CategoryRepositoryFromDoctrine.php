<?php

namespace Module5Project\Repository;

use Doctrine\ORM\EntityManager;
use Module5Project\Entity\Category;

class CategoryRepositoryFromDoctrine implements CategoryRepository
{
    public function __construct(private EntityManager $entityManager)
    {
    }

    public function store(Category $category): void
    {
        $this->entityManager->persist($category);
        $this->entityManager->flush();
    }

    public function read(mixed $args): ?Category
    {
        return $this->entityManager->getRepository(Category::class)->find($args['id']);
    }

    public function getAllCategories(): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('c.categoryId', 'c.name', 'c.description')
            ->from(Category::class, 'c');

        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    public function update(mixed $inputs, mixed $args): void
    {
        $category = $this->entityManager->getRepository(Category::class)->findOneBy(['categoryId' => $args]);

        $reflection = new \ReflectionObject($category);

        foreach ($inputs as $propertyName => $propertyValue) {
            $property = $reflection->getProperty($propertyName);
            $property->setAccessible(true);
            $property->setValue($category, $propertyValue);
        }

        $this->entityManager->flush();
    }

    public function delete(mixed $args): void
    {
        $category = $this->entityManager->getRepository(Category::class)->find($args['id']);
        $this->entityManager->remove($category);
        $this->entityManager->flush();
    }
}
