<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\TokenService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LogInController extends AbstractController
{
    private $tokenService;
    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    #[Route('/api/login', name: 'app_log_in', methods: 'POST')]
    public function loginWithEmail(ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $passwordChecker):JsonResponse
    {
        $em = $doctrine->getManager();
        $data = json_decode($request->getContent(), true);
        $user = $em->getRepository(User::class)->findOneBy(['email' => $data['email']]);
        $checkPassword = $passwordChecker->isPasswordValid($user, $data['password']);

        if(!isset($user) || !$checkPassword){
            return new JsonResponse(['message' => 'Email or password are invalid'], 500);
        }

        $email = $user->getEmail();
        $phoneNumber = $user->getPhoneNumber();
        $token = $this->tokenService->createToken($email, $phoneNumber);

        header("Authorization: Bearer $token");
        return $this->json([
            'success' => true,
            'message' => 'Verification is done successfully',
        ]);
    }
}
