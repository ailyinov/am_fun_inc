<?php

namespace App\Controller;

use App\Dto\CustomerCreate;
use App\Dto\CustomerUpdate;
use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/customer')]
class CustomerController extends AbstractController
{
    #[Route('/', name: 'app_customer_index', methods: ['GET'])]
    public function index(CustomerRepository $customerRepository): Response
    {
        return $this->json([
            'customers' => $customerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_customer_new', methods: ['POST'])]
    public function new(#[MapRequestPayload] CustomerCreate $customerCreate, EntityManagerInterface $entityManager): Response
    {
        $c = new Customer();
        $c->setFirstName($customerCreate->firstName)
            ->setLastName($customerCreate->lastName)
            ->setEmail($customerCreate->email)
            ->setAddress($customerCreate->address)
            ->setFico($customerCreate->fico)
            ->setBirthDate(\DateTime::createFromFormat('Y-m-d', $customerCreate->birthDate))
            ->setPhoneNumber($customerCreate->phoneNumber)
            ->setSsn($customerCreate->ssn);
        $entityManager->persist($c);
        $entityManager->flush();

        return $this->json([
            'customer' => [],
        ]);
    }

    #[Route('/{id}', name: 'app_customer_show', methods: ['GET'])]
    public function show(Customer $customer): Response
    {
        return $this->json([
            'customer' => $customer,
        ]);
    }

    #[Route('/{id}', name: 'app_customer_edit', methods: ['PUT'])]
    public function edit(#[MapRequestPayload] CustomerUpdate $customerUpdate, Customer $customer, EntityManagerInterface $entityManager): JsonResponse
    {
        $customer->setFirstName($customerUpdate->firstName ?? $customer->getFirstName())
            ->setLastName($customerUpdate->lastName ?? $customer->getLastName())
            ->setEmail($customerUpdate->email ?? $customer->getEmail())
            ->setAddress($customerUpdate->address ?? $customer->getAddress())
            ->setFico($customerUpdate->fico ?? $customer->getFico())
            ->setBirthDate($customerUpdate->birthDate ? \DateTime::createFromFormat('Y-m-d', $customerUpdate->birthDate) : $customer->getBirthDate())
            ->setPhoneNumber($customerUpdate->phoneNumber ?? $customer->getPhoneNumber())
            ->setSsn($customerUpdate->ssn ?? $customer->getSsn());
        $entityManager->persist($customer);
        $entityManager->flush();

        return $this->json([
            'customer' => [],
        ]);
    }
}
