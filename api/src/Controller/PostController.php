<?php

namespace App\Controller;

use App\Dto\PostDto;
use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('api/v1/posts', name: 'api_posts_') ]
class PostController extends AbstractController
{
    public function __construct(
        private readonly PostRepository         $postRepository,
        private readonly EntityManagerInterface $em,
    ) {}

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $posts = $this->postRepository->findAll();

        return $this->json($posts);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Post $post): JsonResponse
    {

        return $this->json($post);
    }

    #[Route('/', name: 'create', methods: ['POST'])]
    public function create(#[MapRequestPayload] PostDto $postDto): JsonResponse
    {
        $post = new Post();

        $post->fillWithDto($postDto);

        $this->em->persist($post);
        $this->em->flush();

        return $this->json($post);
    }

    #[Route('/{id}', name: 'edit', methods: ['PUT', 'PATCH'])]
    public function edit(#[MapRequestPayload] PostDto $postDto, Post $post): JsonResponse
    {
        $post->fillWithDto($postDto);

        $this->em->persist($post);
        $this->em->flush();

        return $this->json($post);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(Post $post): JsonResponse
    {
        $this->em->remove($post);
        $this->em->flush();

        return $this->json([]);
    }
}
