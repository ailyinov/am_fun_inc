<?php

namespace App\Entity;

use App\Repository\CustomerLoansRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomerLoansRepository::class)]
class CustomerLoans
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(type: Types::BIGINT)]
    private string $customerId;

    #[ORM\Column(type: Types::BIGINT)]
    private string $loanId;

    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE)]
    private \DateTimeInterface $due_date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getCustomerId(): string
    {
        return $this->customerId;
    }

    public function setCustomerId(string $customerId): static
    {
        $this->customerId = $customerId;

        return $this;
    }

    public function getLoanId(): ?string
    {
        return $this->loanId;
    }

    public function setLoanId(string $loanId): static
    {
        $this->loanId = $loanId;

        return $this;
    }

    public function getDueDate(): \DateTimeInterface
    {
        return $this->due_date;
    }

    public function setDueDate(\DateTimeInterface $due_date): static
    {
        $this->due_date = $due_date;

        return $this;
    }
}
