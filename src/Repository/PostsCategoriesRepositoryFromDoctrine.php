<?php

namespace Module5Project\Repository;

use Doctrine\ORM\EntityManager;
use Module5Project\Entity\Post;

class PostsCategoriesRepositoryFromDoctrine implements PostsCategoriesRepository
{
    public function __construct(private EntityManager $entityManager)
    {
    }

    public function store(Post $post): void
    {
        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }
}
