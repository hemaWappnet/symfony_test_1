<?php

namespace App\Service;

use App\DTO\CommentDTO;
use App\Entity\Comment;
use App\Entity\Post;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;

class CommentService
{
    public function __construct(
        private CommentRepository $commentRepository,
        private EntityManagerInterface $entityManager
    ) {}

    public function getCommentsByPost(Post $post): array
    {
        return $this->commentRepository->findBy(['post' => $post]);
    }

    public function createComment(Post $post, string $content): Comment
    {
        $comment = new Comment();
        $comment->setPost($post);
        $comment->setContent($content);

        $this->entityManager->persist($comment);
        $this->entityManager->flush();

        return $comment;
    }

    public function deleteComment(Comment $comment): void
    {
        $this->entityManager->remove($comment);
        $this->entityManager->flush();
    }

    public function toDTO(Comment $comment): CommentDTO
    {
        return new CommentDTO(
            id: $comment->getId(),
            content: $comment->getContent(),
            postId: $comment->getPost()?->getId(),
            createdAt: $comment->getCreatedAt()?->format('Y-m-d H:i:s')
        );
    }
}