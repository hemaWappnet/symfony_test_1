<?php

namespace App\Controller;

use App\Request\CreateCommentRequest;
use App\Service\CommentService;
use App\Service\PostService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CommentController extends AbstractController
{
    public function __construct(
        private CommentService $commentService,
        private PostService $postService,
        private ValidatorInterface $validator
    ) {}

    #[Route('/posts/{id}/comments', name: 'app_comment_create', methods: ['POST'])]
    public function create(int $id, Request $request): Response
    {
        $post = $this->postService->getPostById($id);

        if (!$post) {
            throw $this->createNotFoundException('Post not found');
        }

        if (!$this->isCsrfTokenValid('comment', $request->request->get('_token'))) {
            $this->addFlash('error', 'Invalid CSRF token.');
            return $this->redirectToRoute('app_post_show', ['id' => $id]);
        }

        $createRequest = new CreateCommentRequest();
        $createRequest->content = $request->request->get('content');

        $errors = $this->validator->validate($createRequest);
        if (count($errors) > 0) {
            $this->addFlash('error', 'Comment could not be saved: ' . $errors[0]->getMessage());
            return $this->redirectToRoute('app_post_show', ['id' => $id]);
        }

        $this->commentService->createComment($post, $createRequest->content);
        $this->addFlash('success', 'Comment added successfully!');

        return $this->redirectToRoute('app_post_show', ['id' => $id]);
    }

    #[Route('/api/posts/{id}/comments', name: 'api_comments', methods: ['GET', 'POST'])]
    public function apiComments(int $id, Request $request): JsonResponse
    {
        $post = $this->postService->getPostById($id);

        if (!$post) {
            return $this->json(['error' => 'Post not found'], 404);
        }

        if ($request->isMethod('POST')) {
            $createRequest = new CreateCommentRequest();
            $createRequest->content = $request->request->get('content');

            $errors = $this->validator->validate($createRequest);
            if (count($errors) > 0) {
                return $this->json(['errors' => (string) $errors], 400);
            }

            $comment = $this->commentService->createComment($post, $createRequest->content);
            return $this->json($this->commentService->toDTO($comment), 201);
        }

        $comments = $this->commentService->getCommentsByPost($post);
        $data = array_map(fn($comment) => $this->commentService->toDTO($comment), $comments);

        return $this->json($data);
    }
}