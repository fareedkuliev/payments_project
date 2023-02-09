<?php

namespace App\Entity;

use App\Repository\CardsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CardsRepository::class)]
class Cards
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $account_id = null;

    #[ORM\Column(length: 16)]
    private ?string $card_number = null;

    #[ORM\Column(length: 20)]
    private ?string $payment_system = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $expiration_date = null;

    #[ORM\Column(length: 4)]
    private ?string $pin_code = null;

    #[ORM\Column(length: 3)]
    private ?string $cvc = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccountId(): ?int
    {
        return $this->account_id;
    }

    public function setAccountId(int $account_id): self
    {
        $this->account_id = $account_id;

        return $this;
    }

    public function getCardNumber(): ?string
    {
        return $this->card_number;
    }

    public function setCardNumber(string $card_number): self
    {
        $this->card_number = $card_number;

        return $this;
    }

    public function getPaymentSystem(): ?string
    {
        return $this->payment_system;
    }

    public function setPaymentSystem(string $payment_system): self
    {
        $this->payment_system = $payment_system;

        return $this;
    }

    public function getExpirationDate(): ?\DateTimeInterface
    {
        return $this->expiration_date;
    }

    public function setExpirationDate(\DateTimeInterface $expiration_date): self
    {
        $this->expiration_date = $expiration_date;

        return $this;
    }

    public function getPinCode(): ?string
    {
        return $this->pin_code;
    }

    public function setPinCode(string $pin_code): self
    {
        $this->pin_code = $pin_code;

        return $this;
    }

    public function getCvc(): ?string
    {
        return $this->cvc;
    }

    public function setCvc(string $cvc): self
    {
        $this->cvc = $cvc;

        return $this;
    }
}
