<?php

namespace App\Domain;

use App\Domain\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

interface CustomerLoansRepositoryInterface
{
    public function findAll(): array;

    public function findOneBy(array $criteria, array|null $orderBy = null): object|null;
}
