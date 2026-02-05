<?php

namespace App\Service;

use App\DTO\PostDTO;
use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;

class PostService
{
    public function __construct(
        private PostRepository $postRepository,
        private EntityManagerInterface $entityManager
    ) {}

    public function getAllPosts(): array
    {
        return $this->postRepository->findAll();
    }

    public function getPostById(int $id): ?Post
    {
        return $this->postRepository->find($id);
    }

    public function createPost(string $title, string $content): Post
    {
        $post = new Post();
        $post->setTitle($title);
        $post->setContent($content);

        $this->entityManager->persist($post);
        $this->entityManager->flush();

        return $post;
    }

    public function updatePost(Post $post, string $title, string $content): Post
    {
        $post->setTitle($title);
        $post->setContent($content);
        $post->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->flush();

        return $post;
    }

    public function deletePost(Post $post): void
    {
        $this->entityManager->remove($post);
        $this->entityManager->flush();
    }

    public function toDTO(Post $post): PostDTO
    {
        return new PostDTO(
            id: $post->getId(),
            title: $post->getTitle(),
            content: $post->getContent(),
            createdAt: $post->getCreatedAt()?->format('Y-m-d H:i:s'),
            updatedAt: $post->getUpdatedAt()?->format('Y-m-d H:i:s'),
            comments: array_map(fn($comment) => [
                'id' => $comment->getId(),
                'content' => $comment->getContent(),
                'createdAt' => $comment->getCreatedAt()?->format('Y-m-d H:i:s')
            ], $post->getComments()->toArray())
        );
    }
}