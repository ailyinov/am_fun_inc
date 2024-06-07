<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $lastName;

    #[ORM\Column(length: 255)]
    private string $firstName;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private \DateTimeInterface $birthDate;

    #[ORM\Column(length: 255)]
    private string $city;

    #[ORM\Column(length: 255)]
    private string $state;

    #[ORM\Column(length: 255)]
    private string $zip;

    #[ORM\Column(length: 255)]
    private string $ssn;

    #[ORM\Column]
    private int $fico;

    #[ORM\Column(length: 255)]
    private string $email;

    #[ORM\Column(length: 255)]
    private string $phoneNumber;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getBirthDate(): \DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): static
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getZip(): string
    {
        return $this->zip;
    }

    public function setZip(string $zip): static
    {
        $this->zip = $zip;

        return $this;
    }

    public function getSsn(): ?string
    {
        return $this->ssn;
    }

    public function setSsn(string $ssn): static
    {
        $this->ssn = $ssn;

        return $this;
    }

    public function getFico(): int
    {
        return $this->fico;
    }

    public function setFico(int $fico): static
    {
        $this->fico = $fico;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function canGetLoan(Loan $loan): bool
    {
        $age = $this->age();
        $ok = $this->fico > Loan::FICO_MIN &&
            $age >= Loan::AGE_MIN &&
            $age <= Loan::AGE_MAX &&
            in_array($this->getState(), Loan::STATES_AVAILABLE);

        return $ok && ($this->getState() !== 'NY' || 1 === rand(0, 1));
    }

    private function age(): int
    {
        $today = new \DateTime();

        return $today->diff($this->getBirthDate())->y;
    }
}
