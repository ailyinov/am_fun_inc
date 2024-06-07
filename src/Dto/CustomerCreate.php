<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CustomerCreate
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly string $lastName,

        #[Assert\NotBlank]
        public readonly string $firstName,

        #[Assert\NotBlank]
        #[Assert\Date]
        public readonly string $birthDate,

        #[Assert\NotBlank]
        public readonly ?string $city,

        #[Assert\NotBlank]
        public readonly ?string $state,

        #[Assert\NotBlank]
        public readonly ?string $zip,

        #[Assert\NotBlank]
        public readonly string $ssn,

        #[Assert\NotBlank]
        #[Assert\GreaterThanOrEqual(300)]
        #[Assert\LessThanOrEqual(850)]
        public readonly int    $fico,

        #[Assert\NotBlank]
        #[Assert\Email]
        public readonly string $email,

        #[Assert\NotBlank]
        public readonly string $phoneNumber,
    )
    {
    }
}
