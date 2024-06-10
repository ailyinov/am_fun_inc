<?php

namespace App\App\MessageHandler;

use App\Domain\CustomerLoansRepositoryInterface;
use App\Domain\Message\LoanIssuedEmail;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class EmailNotificationHandler
{
    public function __construct(
        private CustomerLoansRepositoryInterface $customerLoansRepository,
        // private EmailSenderInterface $es,
    )
    {
    }

    public function __invoke(LoanIssuedEmail $message)
    {
        $customerLoanId = $message->getCustomerLoanId();
        $this->customerLoansRepository->findOneBy(['id' => $customerLoanId]);

        // send email
        // $this->es->sendEmail()
    }
}