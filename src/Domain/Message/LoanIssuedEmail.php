<?php

namespace App\Domain\Message;

readonly class LoanIssuedEmail
{
    public function __construct(
        private int $customerLoanId,
    )
    {
    }

    public function getCustomerLoanId(): int
    {
        return $this->customerLoanId;
    }
    public function getContent(): array
    {
        return [];
    }
}