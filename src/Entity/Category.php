<?php

namespace Module5Project\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity, ORM\Table(name: 'categories')]
class Category
{
    public function __construct(
        #[ORM\Id]
        #[ORM\GeneratedValue(strategy: "CUSTOM")]
        #[ORM\Column(name: 'id', type: 'uuid', unique:true)]
        #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
        private UuidInterface|string $categoryId,
        #[ORM\Column(type: 'string', unique:true)]
        private string $name,
        #[ORM\Column(type: 'string')]
        private string $description,
        #[ORM\ManyToMany(targetEntity: Post::class, mappedBy: 'categories')]
        private Collection $posts = new ArrayCollection(),
    ) {
    }

    public function categoryId(): UuidInterface
    {
        return $this->categoryId;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function posts(): Collection
    {
        return $this->posts;
    }

    public function toArray(): array
    {
        return [
            'id'=>$this->categoryId()->toString(),
            'name'=>$this->name(),
            'description'=>$this->description()
        ];
    }
}
