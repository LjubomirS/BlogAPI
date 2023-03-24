<?php

namespace Module5Project\Repository;

use Module5Project\Entity\Post;

interface PostsCategoriesRepository
{
    public function store(Post $post): void;
}
