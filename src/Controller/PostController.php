<?php

namespace App\Controller;

use App\Request\CreatePostRequest;
use App\Service\PostService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PostController extends AbstractController
{
    public function __construct(
        private PostService $postService,
        private ValidatorInterface $validator
    ) {}

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $posts = $this->postService->getAllPosts();

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('/posts/{id}', name: 'app_post_show', requirements: ['id' => '\d+'])]
    public function show(int $id): Response
    {
        $post = $this->postService->getPostById($id);

        if (!$post) {
            throw $this->createNotFoundException('Post not found');
        }

        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/posts/create', name: 'app_post_create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            if (!$this->isCsrfTokenValid('post', $request->request->get('_token'))) {
                $this->addFlash('error', 'Invalid CSRF token.');
                return $this->render('post/create.html.twig', [
                    'title' => $request->request->get('title'),
                    'content' => $request->request->get('content'),
                ]);
            }

            $createRequest = new CreatePostRequest();
            $createRequest->title = $request->request->get('title');
            $createRequest->content = $request->request->get('content');

            $errors = $this->validator->validate($createRequest);
            if (count($errors) > 0) {
                return $this->render('post/create.html.twig', [
                    'errors' => $errors,
                    'title' => $createRequest->title,
                    'content' => $createRequest->content,
                ]);
            }

            $this->postService->createPost($createRequest->title, $createRequest->content);

            return $this->redirectToRoute('app_home');
        }

        return $this->render('post/create.html.twig');
    }

    #[Route('/api/posts', name: 'api_posts', methods: ['GET'])]
    public function apiIndex(): JsonResponse
    {
        $posts = $this->postService->getAllPosts();
        $data = array_map(fn($post) => $this->postService->toDTO($post), $posts);

        return $this->json($data);
    }

    #[Route('/api/posts/{id}', name: 'api_post_show', methods: ['GET'])]
    public function apiShow(int $id): JsonResponse
    {
        $post = $this->postService->getPostById($id);

        if (!$post) {
            return $this->json(['error' => 'Post not found'], 404);
        }

        return $this->json($this->postService->toDTO($post));
    }
}