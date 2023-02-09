<?php

namespace App\Entity;

use App\Repository\UtilityServicesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtilityServicesRepository::class)]
class UtilityServices
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 55)]
    private ?string $service_name = null;

    #[ORM\Column(length: 55)]
    private ?string $account_number = null;

    #[ORM\Column]
    private ?float $balance = null;

    #[ORM\Column(length: 5)]
    private ?string $currency = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getServiceтфname(): ?string
    {
        return $this->service_тфname;
    }

    public function setServiceтфname(string $service_тфname): self
    {
        $this->service_тфname = $service_тфname;

        return $this;
    }

    public function getAccountNumber(): ?string
    {
        return $this->account_number;
    }

    public function setAccountNumber(string $account_number): self
    {
        $this->account_number = $account_number;

        return $this;
    }

    public function getBalance(): ?float
    {
        return $this->balance;
    }

    public function setBalance(float $balance): self
    {
        $this->balance = $balance;

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
}
