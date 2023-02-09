<?php

namespace App\Controller;

use App\Service\TokenService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;

class RegistrationController extends AbstractController
{
    #[Route('/api/registration', name: 'app_registration', methods: 'POST')]
    public function createUser(ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $em = $doctrine->getManager();
        $data = json_decode($request->getContent(), true);
        $checkEmail = $em->getRepository(User::class)->findBy(['email' => $data['email']]);

        if (isset($checkEmail)){
            return new JsonResponse(['message'=>'User with this email has been already registered'], 500);
        }

        $user = new User();
        $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
        $user->setEmail($data['email'])
                ->setPassword($hashedPassword)
                ->setPhoneNumber($data['phone_number'])
                ->setRole('Null')
                ->setFirstName($data['first_name'])
                ->setLastName($data['last_name']);
        $em->persist($user);
        $em->flush();

        return $this->json(['message' => 'You have been successfully registered'], 201);
    }
}
