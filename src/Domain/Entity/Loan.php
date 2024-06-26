<?php

namespace App\Domain\Entity;

use App\Infrastructure\Repository\LoanRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LoanRepository::class)]
class Loan
{
    const FICO_MIN = 500;

    const AGE_MIN = 18;

    const AGE_MAX = 60;

    const STATES_AVAILABLE = ['CA', 'NY', 'NV'];

    const CA_PERCENT_MOD = 11.4;

    const MIN_INCOME_MONTHLY = 1000;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column]
    private int $termDays;

    #[ORM\Column]
    private float $percent;

    #[ORM\Column]
    private int $amount;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getTermDays(): int
    {
        return $this->termDays;
    }

    public function setTermDays(int $termDays): static
    {
        $this->termDays = $termDays;

        return $this;
    }

    public function getPercent(): float
    {
        return $this->percent;
    }

    public function setPercent(float $percent): static
    {
        $this->percent = $percent;

        return $this;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getStatePercent(string $state): float
    {
        return $state === 'CA' ? $this->getPercent() + self::CA_PERCENT_MOD : $this->getPercent();
    }
}
