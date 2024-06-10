<?php

namespace App\Http\Controller;

use App\App\CustomerCreator;
use App\App\CustomerUpdater;
use App\App\LoanIssuer;
use App\Domain\CustomerRepositoryInterface;
use App\Domain\Entity\Customer;
use App\Domain\Entity\Loan;
use App\Http\RequestDto\CustomerCreate;
use App\Http\RequestDto\CustomerUpdate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/customer')]
class CustomerController extends AbstractController
{
    #[Route('/', name: 'app_customer_index', methods: ['GET'])]
    public function index(CustomerRepositoryInterface $customerRepository): JsonResponse
    {
        return $this->json([
            'customers' => $customerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_customer_new', methods: ['POST'])]
    public function new(#[MapRequestPayload] CustomerCreate $customerCreate, CustomerCreator $customerCreator): JsonResponse
    {
        $customer = $customerCreator->create($customerCreate);

        return $this->json([
            'customer' => $customer,
        ]);
    }

    #[Route('/{customer}', name: 'app_customer_show', methods: ['GET'])]
    public function show(Customer $customer): JsonResponse
    {
        return $this->json([
            'customer' => $customer,
        ]);
    }

    #[Route('/{customer}', name: 'app_customer_edit', methods: ['PUT'])]
    public function edit(#[MapRequestPayload] CustomerUpdate $customerUpdate, Customer $customer, CustomerUpdater $customerUpdater): JsonResponse
    {
        $customer = $customerUpdater->update($customerUpdate, $customer);

        return $this->json([
            'customer' => $customer,
        ]);
    }

    #[Route('/{customer}/is-loan-available/{loan}', name: 'app_customer_loan_check', methods: ['GET'])]
    public function isLoanAvailable(Customer $customer, Loan $loan): JsonResponse
    {
        return $this->json([
            'ok' => $customer->canGetLoan($loan),
        ]);
    }

    #[Route('/{customer}/issue-loan/{loan}', name: 'app_customer_loan_issue', methods: ['GET'])]
    public function issueLoan(Customer $customer, Loan $loan, LoanIssuer $loanIssuer): JsonResponse
    {
        $loanIssuer->issue($customer, $loan);

        return $this->json([
            'ok' => true,
        ]);
    }
}
