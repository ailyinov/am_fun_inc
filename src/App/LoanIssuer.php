<?php

namespace App\App;

use App\Domain\Entity\Customer;
use App\Domain\Entity\CustomerLoans;
use App\Domain\Entity\Loan;
use Doctrine\ORM\EntityManagerInterface;

readonly class LoanIssuer
{
    public function __construct(
        private EntityManagerInterface $em,
    )
    {
    }

    public function issue(Customer $customer, Loan $loan): void
    {
        if ($customer->canGetLoan($loan)) {
            $cl = new CustomerLoans();
            $cl->setCustomerId($customer->getId())
                ->setLoanId($loan->getId())
                ->setDueDate((new \DateTime())->add(new \DateInterval(sprintf('P%sD', $loan->getTermDays()))))
                ->setPercent($loan->getStatePercent($customer->getState()));

            $this->em->persist($loan);
            $this->em->flush();
        }
    }
}