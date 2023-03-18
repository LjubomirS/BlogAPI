<?php

namespace Module4Project\Repository;

use Module4Project\Entity\Post;
use PDO;

class PostsCategoriesRepositoryFromPdo implements PostsCategoriesRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    private function storeQuery(): string
    {
        return <<<SQL
            INSERT INTO posts_categories (post_id, category_id)
            VALUES (:post_id, :category_id)
        SQL;
    }

    public function store(Post $post): void
    {
        $sql = $this->storeQuery();
        $stm = $this->pdo->prepare($sql);

        foreach ($post->categories() as $category) {
            $params = [
                ':post_id' => $post->postId(),
                ':category_id' => $category['id'],
            ];

            $stm->execute($params);
        }
    }
}
