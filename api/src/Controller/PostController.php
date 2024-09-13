<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
    public function create(Request $request, SerializerInterface $serializer, ValidatorInterface $validator): JsonResponse
    {
        $data = $request->getContent();
        $post = $serializer->deserialize($data, Post::class, 'json');

        $errors = $validator->validate($post);
        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

        $this->em->persist($post);
        $this->em->flush();

        return $this->json($post);
    }

    #[Route('/{id}', name: 'edit', methods: ['PUT', 'PATCH'])]
    public function edit(Request $request, Post $post, ValidatorInterface $validator): JsonResponse
    {

        $data = json_decode($request->getContent());
        $post->setTitle($data->title ?? '');
        $post->setDescription($data->description ?? '');

        $errors = $validator->validate($post);
        if (count($errors) > 0) {
            return $this->json($errors, Response::HTTP_BAD_REQUEST);
        }

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
