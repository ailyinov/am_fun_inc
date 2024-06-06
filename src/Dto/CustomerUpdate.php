<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CustomerUpdate
{
    public function __construct(
        public readonly ?string $lastName,

        public readonly ?string $firstName,

        #[Assert\Date]
        public readonly ?string $birthDate,

        public readonly ?string $address,

        public readonly ?string $ssn,

        #[Assert\GreaterThanOrEqual(300)]
        #[Assert\LessThanOrEqual(850)]
        public readonly ?int    $fico,

        #[Assert\Email]
        public readonly ?string $email,

        public readonly ?string $phoneNumber,
    )
    {
    }
}
