<?php

namespace App\Controller;

use App\Entity\Accounts;
use App\Entity\Cards;
use App\Entity\UtilityServices;
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

    #[Route('/api/payment', name: 'app_new_payment', methods: 'GET')]
    public function getData(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        $authorizationHeader = $request->headers->get("Authorization");
        $token = $this->tokenService->decodeToken(substr($authorizationHeader, 7));
        $em = $doctrine->getManager();
        $email = $token->data['0'];

        $cards = $em->getRepository(Cards::class)->findBy(['user_email'=>$email]);
        $cardsData = [];
        foreach ($cards as $card){
            array_push($cardsData, [$card->getCardNumber(), $card->getPaymentSystem(), $card->getBalance()]);
        };

        $services = $em->getRepository(UtilityServices::class)->findAll();
        $servicesData = [];
        foreach ($services as $service){
            array_push($servicesData, $service->getServiceName());
        }

        return $this->json([
            'success' => true,
            'cards' => $cardsData,
            'services' => $servicesData
        ]);
    }
}
