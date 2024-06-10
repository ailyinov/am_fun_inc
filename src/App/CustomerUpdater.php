<?php

namespace App\App;

use App\Domain\Entity\Customer;
use App\Http\RequestDto\CustomerUpdate;
use Doctrine\ORM\EntityManagerInterface;

readonly class CustomerUpdater
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    )
    {
    }

    public function update(CustomerUpdate $customerUpdate, Customer $customer): Customer
    {
        $customer->setFirstName($customerUpdate->firstName ?? $customer->getFirstName())
            ->setLastName($customerUpdate->lastName ?? $customer->getLastName())
            ->setEmail($customerUpdate->email ?? $customer->getEmail())
            ->setCity($customerUpdate->city ?? $customer->getCity())
            ->setState($customerUpdate->state ?? $customer->getState())
            ->setZip($customerUpdate->zip ?? $customer->getZip())
            ->setFico($customerUpdate->fico ?? $customer->getFico())
            ->setBirthDate($customerUpdate->birthDate ? \DateTime::createFromFormat('Y-m-d', $customerUpdate->birthDate) : $customer->getBirthDate())
            ->setPhoneNumber($customerUpdate->phoneNumber ?? $customer->getPhoneNumber())
            ->setSsn($customerUpdate->ssn ?? $customer->getSsn());

        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        return $customer;
    }
}