<?php

namespace Module5Project\Repository;

use Module5Project\Entity\Post;

interface PostRepository
{
    public function store(Post $post): void;

    public function read(mixed $args): ?Post;
    /**
     * @return Post[]
     */
    public function getAllPosts(): array;
    public function update(mixed $inputs, mixed $args): void;
    public function delete(mixed $args): void;
}
