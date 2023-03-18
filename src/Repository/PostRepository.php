<?php

namespace Module4Project\Repository;

use Module4Project\Entity\Post;

interface PostRepository
{
    public function store(Post $post): void;
    /**
     * @return Post[]
     */
    public function read(mixed $args): array;
    /**
     * @return Post[]
     */
    public function getAllPosts(): array;
    public function update(mixed $inputs, mixed $args): void;
    public function delete(mixed $args): void;
}
