<?php

namespace App\Controller;

use App\Entity\Accounts;
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

        if($data['type_of_transaction'] === 'utility_service'){
            $sendFromCard = $em->getRepository(Cards::class)->findOneBy(['card_number' => $data['sender_card']]);
            $utilityServiceAccount = $em->getRepository(UtilityServices::class)->findOneBy(['account_number'=> $data['recipient_card_account']]);
            $sendFromCard->setBalance($sendFromCard->getBalance() - $data['amount']);
            $utilityServiceAccount->setBalance($utilityServiceAccount->getBalance() + $data['amount']);

            $senderAccount = $em->getRepository(Accounts::class)->findOneBy(['user_email' => $email]);
            $senderAccount->setBalance($senderAccount->getBalance() - $data['amount']);
        } else{
            $sender = $em->getRepository(Cards::class)->findOneBy(['card_number' => $data['sender_card']]);
            $recipient = $em->getRepository(Cards::class)->findOneBy(['card_number' => $data['recipient_card_account']]);
            $sender->setBalance($sender->getBalance() - $data['amount']);
            $recipient->setBalance($recipient->getBalance() + $data['amount']);

            $senderAccount = $em->getRepository(Accounts::class)->findOneBy(['user_email' => $email]);
            $recipientAccount = $em->getRepository(Accounts::class)->findOneBy(['id' => $recipient->getAccountId()]);
            $senderAccount->setBalance($senderAccount->getBalance() - $data['amount']);
            $recipientAccount->setBalance($recipientAccount->getBalance() + $data['amount']);
        }

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
