<?php

namespace App\Controller;

use App\Dto\UserDto;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('api/v1/users', name: 'api_users_') ]
class UserController extends AbstractController
{
    public function __construct(
        private readonly UserRepository         $userRepository,
        private readonly EntityManagerInterface $em,
    ) {}

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $posts = $this->userRepository->findAll();

        return $this->json($posts);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(User $user): JsonResponse
    {

        return $this->json($user);
    }

    #[Route('/', name: 'create', methods: ['POST'])]
    public function create(#[MapRequestPayload(validationGroups: 'create')] UserDto $userDto, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $user = new User();
        $user->fillWithDto($userDto);
        $plaintextPassword = $userDto->password;

        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);

        $this->em->persist($user);
        $this->em->flush();

        return $this->json($user);
    }

    #[Route('/{id}', name: 'edit', methods: ['PUT', 'PATCH'])]
    public function edit(User $user, #[MapRequestPayload(validationGroups: 'edit')] UserDto $userDto): JsonResponse
    {
        /** @ToDo Figure out how to ignore current record email in validation */
        $user->fillWithDto($userDto);

        $this->em->persist($user);
        $this->em->flush();

        return $this->json($user);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(User $user): JsonResponse
    {
        $this->em->remove($user);
        $this->em->flush();

        return $this->json([]);
    }
}
