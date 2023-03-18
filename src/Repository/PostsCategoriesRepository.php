<?php

namespace Module4Project\Repository;

use Module4Project\Entity\Post;

interface PostsCategoriesRepository
{
    public function store(Post $post): void;
}
