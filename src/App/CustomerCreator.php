<?php

namespace App\App;

use App\Domain\Entity\Customer;
use App\Http\RequestDto\CustomerCreate;
use Doctrine\ORM\EntityManagerInterface;

readonly class CustomerCreator
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    )
    {
    }

    public function create(CustomerCreate $customerCreate): Customer
    {
        $customer = new Customer();
        $customer->setFirstName($customerCreate->firstName)
            ->setLastName($customerCreate->lastName)
            ->setEmail($customerCreate->email)
            ->setCity($customerCreate->city)
            ->setState($customerCreate->state)
            ->setZip($customerCreate->zip)
            ->setFico($customerCreate->fico)
            ->setBirthDate(\DateTime::createFromFormat('Y-m-d', $customerCreate->birthDate))
            ->setPhoneNumber($customerCreate->phoneNumber)
            ->setMonthlyIncome($customerCreate->monthlyIncome)
            ->setSsn($customerCreate->ssn);

        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        return $customer;
    }
}