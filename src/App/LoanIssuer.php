<?php

namespace App\App;

use App\Domain\Entity\Customer;
use App\Domain\Entity\CustomerLoans;
use App\Domain\Entity\Loan;
use Doctrine\ORM\EntityManagerInterface;

class LoanIssuer
{
    public function __construct(
        private readonly EntityManagerInterface $em,
    )
    {
    }

    public function issue(Customer $customer, Loan $loan)
    {
        if ($customer->canGetLoan($loan)) {
            $cl = new CustomerLoans();
            $cl->setCustomerId($customer->getId())
                ->setLoanId($loan->getId())
                ->setDueDate((new \DateTime())->add(new \DateInterval($loan->getTermDays())))
                ->setPercent($loan->getPercent());

            $this->em->persist($loan);
            $this->em->flush();
        }
    }
}