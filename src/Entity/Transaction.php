<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 55)]
    private ?string $type_of_transaction = null;

    #[ORM\Column(length: 20)]
    private ?string $sender_card = null;

    #[ORM\Column(length: 55)]
    private ?string $recipient_card_account = null;

    #[ORM\Column]
    private ?float $amount = null;

    #[ORM\Column(length: 5)]
    private ?string $currency = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 55)]
    private ?string $name_of_payment = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeOfTransaction(): ?string
    {
        return $this->type_of_transaction;
    }

    public function setTypeOfTransaction(string $type_of_transaction): self
    {
        $this->type_of_transaction = $type_of_transaction;

        return $this;
    }

    public function getSenderCard(): ?string
    {
        return $this->sender_card;
    }

    public function setSenderCard(string $sender_card): self
    {
        $this->sender_card = $sender_card;

        return $this;
    }

    public function getRecipientCardAccount(): ?string
    {
        return $this->recipient_card_account;
    }

    public function setRecipientCardAccount(string $recipient_card_account): self
    {
        $this->recipient_card_account = $recipient_card_account;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getNameOfPayment(): ?string
    {
        return $this->name_of_payment;
    }

    public function setNameOfPayment(string $name_of_payment): self
    {
        $this->name_of_payment = $name_of_payment;

        return $this;
    }
}