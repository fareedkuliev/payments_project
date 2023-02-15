<?php

namespace App\Controller;

use App\Entity\Cards;
use App\Entity\Transaction;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\TokenService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NewInternalTransferController extends AbstractController
{
    protected $tokenService;
    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    #[Route('/api/internal_transfer', name: 'app_new_internal_transfer', methods: 'GET')]
    public function getCardsInfo(ManagerRegistry $doctrine, Request $request): JsonResponse
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
        $cards = $em->getRepository(Cards::class)->findBy(['user_email' => $email]);
        $cardsData = [];
        foreach ($cards as $card){
            array_push($cardsData, [$card->getCardNumber(), $card->getPaymentSystem(), $card->getBalance()]);
        };

        return $this->json([
            'success' => true,
            'cards' => $cardsData,
        ]);
    }

    #[Route('/api/internal_transfer', name: 'new_internal_transfer', methods: 'POST')]
    public function makeTransfer(ManagerRegistry $doctrine, Request $request):JsonResponse
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

        $sendFrom = $em->getRepository(Cards::class)->findOneBy(['card_number' => $data['sender_card']]);
        $sendTo = $em->getRepository(Cards::class)->findOneBy(['card_number' => $data['recipient_card_account']]);
        $sendFrom->setBalance($sendFrom->getBalance() - $data['amount']);
        $sendTo->setBalance($sendTo->getBalance() + $data['amount']);

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

        return $this->json([
            'success' => true,
            'message' => 'Your transaction has been successfully done'
        ], 201);
    }
}
