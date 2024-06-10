<?php

namespace App\Domain;

use App\Domain\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

interface CustomerRepositoryInterface
{
    public function findAll(): array;
}
