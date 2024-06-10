<?php

namespace App\Tests;

use App\Domain\Entity\Customer;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    public function testDeclineByState(): void
    {
        $c = new Customer();
        $c->setState('WY')
            ->setFico(501)
            ->setMonthlyIncome(1001)
            ->setBirthDate(new \DateTime('now -22 year'));

        $this->assertFalse($c->canGetLoan());
    }

    public function testDeclineByIncome(): void
    {
        $c = new Customer();
        $c->setState('CA')
            ->setFico(501)
            ->setMonthlyIncome(100)
            ->setBirthDate(new \DateTime('now -22 year'));

        $this->assertFalse($c->canGetLoan());
    }

    public function testDeclineByFico(): void
    {
        $c = new Customer();
        $c->setState('CA')
            ->setFico(300)
            ->setMonthlyIncome(100000)
            ->setBirthDate(new \DateTime('now -22 year'));

        $this->assertFalse($c->canGetLoan());
    }

    public function testDeclineByAge(): void
    {
        $c = new Customer();
        $c->setState('CA')
            ->setFico(700)
            ->setMonthlyIncome(100000)
            ->setBirthDate(new \DateTime('now -99 year'));

        $this->assertFalse($c->canGetLoan());
    }

    public function testSuccess(): void
    {
        $c = new Customer();
        $c->setState('CA')
            ->setFico(700)
            ->setMonthlyIncome(100000)
            ->setBirthDate(new \DateTime('now -33 year'));

        $this->assertTrue($c->canGetLoan());
    }
}
