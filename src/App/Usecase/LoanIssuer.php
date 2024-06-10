<?php

namespace App\App\Usecase;

use App\Domain\Entity\Customer;
use App\Domain\Entity\CustomerLoans;
use App\Domain\Entity\Loan;
use App\Domain\Message\LoanIssuedEmail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

readonly class LoanIssuer
{
    public function __construct(
        private EntityManagerInterface $em,
        private MessageBusInterface $bus,
    )
    {
    }

    /**
     * @throws ExceptionInterface
     */
    public function issue(Customer $customer, Loan $loan): void
    {
        if ($customer->canGetLoan()) {
            $cl = new CustomerLoans();
            $cl->setCustomerId($customer->getId())
                ->setLoanId($loan->getId())
                ->setDueDate((new \DateTime())->add(new \DateInterval(sprintf('P%sD', $loan->getTermDays()))))
                ->setPercent($loan->getStatePercent($customer->getState()));

            $this->em->persist($cl);
            $this->em->flush();

            $this->bus->dispatch(new LoanIssuedEmail($cl->getId()));
        }
    }
}