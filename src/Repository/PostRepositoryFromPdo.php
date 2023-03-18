<?php

namespace Module4Project\Repository;

use Module4Project\Controller\FileController;
use Module4Project\Entity\Post;
use PDO;

class PostRepositoryFromPdo implements PostRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    private function storeQuery(): string
    {
        return <<<SQL
            INSERT INTO posts (post_id, title, slug, content, thumbnail, author, posted_at)
            VALUES (:post_id, :title, :slug, :content, :thumbnail, :author, :posted_at)
        SQL;
    }

    private function updateQuery(): string
    {
        return <<<SQL
            UPDATE posts
            SET content = :content, thumbnail = :thumbnail
            WHERE slug = :slug
        SQL;
    }

    public function store(Post $post): void
    {
        $sql = $this->storeQuery();
        $stm = $this->pdo->prepare($sql);

        $params = [
            ':post_id' => $post->postId(),
            ':title' => $post->title(),
            ':slug' => $post->slug(),
            ':content' => $post->content(),
            ':thumbnail' => $post->thumbnail(),
            ':author' => $post->author(),
            ':posted_at' => $post->postedAt(),
        ];

        $stm->execute($params);
    }

    /**
     * @return Post[]
     */
    public function read(mixed $args): array
    {
        $stm = $this->pdo->prepare(<<<SQL
            SELECT posts.*, categories.* 
            FROM posts 
            JOIN posts_categories ON posts.post_id = posts_categories.post_id 
            JOIN categories ON posts_categories.category_id = categories.category_id 
            WHERE posts.slug = :slug
        SQL);
        $stm->bindParam(':slug', $args['slug']);
        $stm->execute();
        $data = $stm->fetchAll(\PDO::FETCH_ASSOC);

        if (empty($data)) {
            return [];
        }

        $post = [];
        $categories = [];

        foreach ($data as $row) {
            if (!isset($post['id'])) {
                $post = [
                    'id' => $row['post_id'],
                    'title' => $row['title'],
                    'slug' => $row['slug'],
                    'content' => $row['content'],
                    'thumbnail' => $row['thumbnail'],
                    'author' => $row['author'],
                    'posted_at' => $row['posted_at']
                ];
            }

            $categories[] = [
                'id' => $row['category_id'],
                'name' => $row['name'],
                'description' => $row['description']
            ];
        }

        $post['categories'] = $categories;

        return $post;
    }

    /**
     * @return Post[]
     */
    public function getAllPosts(): array
    {
        $stm = $this->pdo->prepare('SELECT * FROM posts');
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function update(mixed $inputs, mixed $args): void
    {
        $sql = $this->updateQuery();
        $stm = $this->pdo->prepare($sql);

        $thumbnail = new FileController($inputs['thumbnail']);
        $filePath = 'http://localhost:8888/uploads/' . $thumbnail->handle();

        $params = [
            ':slug' => $args['slug'],
            ':content' => $inputs['content'],
            ':thumbnail' => $filePath
        ];

        $stm->execute($params);
    }

    public function delete(mixed $args): void
    {
        $stm = $this->pdo->prepare('DELETE FROM posts WHERE slug = :slug');
        $stm->bindParam(':slug', $args['slug']);
        $stm->execute();
    }
}
