<?php

namespace App\Http\RequestDto;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CustomerUpdate
{
    public function __construct(
        public readonly ?string $lastName,

        public readonly ?string $firstName,

        #[Assert\Date]
        public readonly ?string $birthDate,

        public readonly ?string $city,

        public readonly ?string $state,

        public readonly ?string $zip,

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
