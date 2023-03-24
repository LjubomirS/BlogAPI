<?php

namespace Module5Project\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity, ORM\Table(name: 'posts')]
class Post
{
    public function __construct(
        #[ORM\Id]
        #[ORM\GeneratedValue(strategy: "CUSTOM")]
        #[ORM\Column(name: 'id', type: 'uuid', unique:true)]
        #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
        private UuidInterface|string $postId,
        #[ORM\Column(type: 'string')]
        private string $title,
        #[ORM\Column(type: 'string')]
        private string $slug,
        #[ORM\Column(type: 'string')]
        private string $content,
        #[ORM\Column(type: 'string')]
        private string $thumbnail,
        #[ORM\Column(type: 'string')]
        private string $author,
        #[ORM\Column(name: 'posted_at', type: 'datetime_immutable')]
        private \DateTimeImmutable $postedAt,
        #[ORM\ManyToMany(targetEntity: Category::class,  inversedBy:'posts')]
        private Collection|array $categories = new ArrayCollection(),
    ) {
    }

    public function postId(): string
    {
        return $this->postId;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function thumbnail(): string
    {
        return $this->thumbnail;
    }

    public function author(): string
    {
        return $this->author;
    }

    public function postedAt(): \DateTimeImmutable
    {
        return $this->postedAt;
    }

    public function categories(): Collection|array
    {
        return $this->categories;
    }

    public function toArray(): array
    {
        return [
            'id'=>$this->postId(),
            'title'=>$this->title(),
            'slug'=>$this->slug(),
            'content'=>$this->content(),
            'thumbnail'=>$this->thumbnail(),
            'author'=>$this->author(),
            'posted_at'=>$this->postedAt()
        ];
    }

    public function displayPost(Post $post): array
    {
        $postData = $post->toArray();

        foreach ($post->categories() as $category) {
            $postData['categories'][] = [
                'id' => $category->categoryId(),
                'name' => $category->name(),
                'description' => $category->description()
            ];
        }

        return $postData;
    }

}
