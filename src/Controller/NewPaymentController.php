<?php

namespace App\Controller;

use App\Entity\Cards;
use App\Entity\Transaction;
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

        if(empty($authorizationHeader)){
            return $this->json([
                'success' => false,
                'message' => 'Unauthorized user'
            ], 500);
        }

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

    #[Route('/api/payment', name: 'new_payment', methods: 'POST')]
    public function makePayment(ManagerRegistry $doctrine, Request $request):JsonResponse
    {
        $authorizationHeader = $request->headers->get("Authorization");

        if(empty($authorizationHeader)){
            return $this->json([
                'success' => false,
                'message' => 'Unauthorized user'
            ], 500);
        }

        $token = $this->tokenService->decodeToken(substr($authorizationHeader, 7));
        $em = $doctrine->getManager();
        $email = $token->data['0'];
        $data = json_decode($request->getContent(), true);

        $sender = $em->getRepository(Cards::class)->findOneBy(['card_number' => $data['sender_card']]);
        $recipient = $em->getRepository(Cards::class)->findOneBy(['card_number' => $data['recipient_card_account']]);
        $sender->setBalance($sender->getBalance() - $data['amount']);
        $recipient->setBalance($recipient->getBalance() + $data['amount']);
        $em->flush();

        $transaction = new Transaction();
        $transaction->setTypeOfTransaction($data['type_of_transaction'])
                    ->setSenderCard($data['sender_card'])
                    ->setRecipientCardAccount($data['recipient_card_account'])
                    ->setAmount($data['amount'])
                    ->setCurrency($data['currency'])
                    ->setDate(date_create())
                    ->setNameOfPayment($data['name_of_payment']);
        $em->persist($transaction);
        $em->flush();

        return $this->json('This is POST method');
    }

}
