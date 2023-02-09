<?php

namespace App\Controller;

use App\Service\TokenService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NewPaymentController extends AbstractController
{
    protected $tokenService;
    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    #[Route('/new/payment', name: 'app_new_payment', methods: 'GET')]
    public function getData(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        $authorizationHeader = $request->headers->get("Authorization");
        $token = $this->tokenService->decodeToken(substr($authorizationHeader, 7));

        return $this->json([
        ]);
    }
}
