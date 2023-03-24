<?php

namespace Module5Project\Repository;

use Doctrine\ORM\EntityManager;
use Module5Project\Entity\Post;

class PostRepositoryFromDoctrine implements PostRepository
{
    public function __construct(private EntityManager $entityManager)
    {
    }

    public function store(Post $post): void
    {
        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }

    public function read(mixed $args): ?Post
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('p', 'c')
            ->from(Post::class, 'p')
            ->leftJoin('p.categories', 'c')
            ->where('p.postId = :postId')
            ->setParameter('postId', $args['id']);

        $query = $queryBuilder->getQuery();
        $post = $query->getOneOrNullResult();

        return $post;
    }

    public function findByTitle($inputs): bool
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('COUNT(p.postId)')
            ->from(Post::class, 'p')
            ->where('p.title = :title')
            ->setParameter('title', $inputs['title']);

        $query = $queryBuilder->getQuery();
        $result = $query->getSingleScalarResult();

        return $result > 0;
    }

    public function getAllPosts(): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('p.postId', 'p.title', 'p.slug', 'p.content', 'p.thumbnail', 'p.author', 'p.postedAt')
            ->from(Post::class, 'p');

        $query = $queryBuilder->getQuery();

        return $query->getResult();
    }

    public function update(mixed $propertiesToUpdate, mixed $args): void
    {
        $post = $this->entityManager->getRepository(Post::class)->findOneBy(['postId' => $args]);

        $reflection = new \ReflectionObject($post);

        foreach ($propertiesToUpdate as $propertyName => $propertyValue) {
            $property = $reflection->getProperty($propertyName);
            $property->setAccessible(true);
            $property->setValue($post, $propertyValue);
        }

        $this->entityManager->flush();
    }

    public function delete(mixed $args): void
    {
        $post = $this->entityManager->getRepository(Post::class)->find($args['id']);
        $this->entityManager->remove($post);
        $this->entityManager->flush();
    }
}
