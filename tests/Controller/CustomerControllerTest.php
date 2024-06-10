<?php

namespace App\Test\Controller;

use App\Domain\Entity\Customer;
use App\Domain\Entity\CustomerLoans;
use App\Domain\Entity\Loan;
use App\Infrastructure\Repository\CustomerLoansRepository;
use App\Infrastructure\Repository\LoanRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CustomerControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private LoanRepository $loanRepo;
    private CustomerLoansRepository $customerLoansRepo;
    private string $path = '/customer/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Customer::class);


        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->loanRepo = $this->manager->getRepository(Loan::class);
        foreach ($this->loanRepo->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->customerLoansRepo = $this->manager->getRepository(CustomerLoans::class);
        foreach ($this->customerLoansRepo->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->client->request(
            'POST',
            sprintf('%snew', $this->path),
            [
                'lastName' => 'test',
                'firstName' => ' test',
                'birthDate' => '1990-08-08',
                'city' => 'New York',
                'state' => 'NY',
                'zip' => '2208',
                'ssn' => '1234t5667',
                'fico' => 300,
                'email' => 'test@email.com',
                'phoneNumber' => '+105999873',
                'monthlyIncome' => '20000',
            ]
        );

        self::assertResponseStatusCodeSame(200);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $fixture = new Customer();
        $fixture->setLastName('My Title');
        $fixture->setFirstName('My Title');
        $fixture->setBirthDate(new \DateTime());
        $fixture->setCity('New York');
        $fixture->setState('NY');
        $fixture->setZip('2222');
        $fixture->setSsn('My Title');
        $fixture->setFico(300);
        $fixture->setEmail('My Title');
        $fixture->setPhoneNumber('My Title');
        $fixture->setMonthlyIncome(5000);

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);

        // Use assertions to check that the properties are properly displayed.
    }

    public function testShowAll(): void
    {
        $fixture = new Customer();
        $fixture->setLastName('My Title');
        $fixture->setFirstName('My Title');
        $fixture->setBirthDate(new \DateTime());
        $fixture->setCity('New York');
        $fixture->setState('NY');
        $fixture->setZip('2222');
        $fixture->setSsn('My Title');
        $fixture->setFico(300);
        $fixture->setEmail('My Title');
        $fixture->setPhoneNumber('My Title');
        $fixture->setMonthlyIncome(5000);

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s', $this->path));

        self::assertResponseStatusCodeSame(200);

        $response = $this->client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals($fixture->getId(), $responseData['customers'][0]['id']);
    }

    public function testEdit(): void
    {
        $fixture = new Customer();
        $fixture->setLastName('Value');
        $fixture->setFirstName('Value');
        $fixture->setBirthDate(new \DateTime());
        $fixture->setCity('New York');
        $fixture->setState('NY');
        $fixture->setZip('2222');
        $fixture->setSsn('Value');
        $fixture->setFico(300);
        $fixture->setEmail('Value');
        $fixture->setPhoneNumber('Value');
        $fixture->setMonthlyIncome(5000);

        $this->manager->persist($fixture);
        $this->manager->flush();

        $expectedBirthDate = (new \DateTime('now -1 day'))->format('Y-m-d');
        $this->client->request(
            'PUT',
            sprintf('%s%s', $this->path, $fixture->getId()),
            [
                'lastName' => 'test22',
                'firstName' => ' test22',
                'birthDate' => $expectedBirthDate,
                'city' => 'Los Angeles',
                'state' => 'CA',
                'zip' => '2223',
                'ssn' => '1234t5667',
                'fico' => 301,
                'email' => 'test@email.com',
                'phoneNumber' => '+105999873',
            ]
        );

        self::assertResponseStatusCodeSame(200);

        $fixture = $this->repository->findAll();

        self::assertSame('test22', $fixture[0]->getLastName());
        self::assertSame(' test22', $fixture[0]->getFirstName());
        self::assertSame($expectedBirthDate, $fixture[0]->getBirthDate()->format('Y-m-d'));
        self::assertSame('Los Angeles', $fixture[0]->getCity());
        self::assertSame('CA', $fixture[0]->getState());
        self::assertSame('2223', $fixture[0]->getZip());
        self::assertSame('1234t5667', $fixture[0]->getSsn());
        self::assertSame(301, $fixture[0]->getFico());
        self::assertSame('test@email.com', $fixture[0]->getEmail());
        self::assertSame('+105999873', $fixture[0]->getPhoneNumber());
    }

    public function testEditEmptyPayload(): void
    {
        $expectedBirthDate = new \DateTime('now -1 day');
        $fixture = new Customer();
        $fixture->setLastName('Value');
        $fixture->setFirstName('Value');
        $fixture->setBirthDate($expectedBirthDate);
        $fixture->setCity('New York');
        $fixture->setState('NY');
        $fixture->setZip('2222');
        $fixture->setSsn('Value');
        $fixture->setFico(300);
        $fixture->setEmail('Value');
        $fixture->setPhoneNumber('Value');
        $fixture->setMonthlyIncome(5000);

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request(
            'PUT',
            sprintf('%s%s', $this->path, $fixture->getId()),
            [
                "" => "",
            ]
        );

        self::assertResponseStatusCodeSame(200);

        $fixture = $this->repository->findAll();

        self::assertSame('Value', $fixture[0]->getLastName());
        self::assertSame('Value', $fixture[0]->getFirstName());
        self::assertSame($expectedBirthDate->format('Y-m-d'), $fixture[0]->getBirthDate()->format('Y-m-d'));
        self::assertSame('New York', $fixture[0]->getCity());
        self::assertSame('NY', $fixture[0]->getState());
        self::assertSame('2222', $fixture[0]->getZip());
        self::assertSame('Value', $fixture[0]->getSsn());
        self::assertSame(300, $fixture[0]->getFico());
        self::assertSame('Value', $fixture[0]->getEmail());
        self::assertSame('Value', $fixture[0]->getPhoneNumber());
    }

    public function testIsLoanAvailable(): void
    {
        $fc = new Customer();
        $fc->setLastName('Value');
        $fc->setFirstName('Value');
        $fc->setBirthDate(new \DateTime('now -22 year'));
        $fc->setCity('Los Angeles');
        $fc->setState('CA');
        $fc->setZip('2223');
        $fc->setSsn('Value');
        $fc->setFico(600);
        $fc->setEmail('Value');
        $fc->setPhoneNumber('Value');
        $fc->setMonthlyIncome(5000);
        $this->manager->persist($fc);

        $fl = new Loan();
        $fl->setPercent(2)
            ->setName('business')
            ->setAmount(1000000)
            ->setTermDays(365 * 5);
        $this->manager->persist($fl);

        $this->manager->flush();

        $this->client->request(
            'GET',
            sprintf('%s%s/is-loan-available/%s', $this->path, $fc->getId(), $fl->getId()),
        );

        $response = $this->client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertTrue($responseData['ok']);
    }

    public function testIssueLoan(): void
    {
        $fc = new Customer();
        $fc->setLastName('Value');
        $fc->setFirstName('Value');
        $fc->setBirthDate(new \DateTime('now -22 year'));
        $fc->setCity('Los Angeles');
        $fc->setState('CA');
        $fc->setZip('2223');
        $fc->setSsn('Value');
        $fc->setFico(600);
        $fc->setEmail('Value');
        $fc->setPhoneNumber('Value');
        $fc->setMonthlyIncome(5000);
        $this->manager->persist($fc);

        $fl = new Loan();
        $fl->setPercent(2)
            ->setName('business')
            ->setAmount(1000000)
            ->setTermDays(365 * 5);
        $this->manager->persist($fl);

        $this->manager->flush();

        $this->client->request(
            'POST',
            sprintf('%s%s/issue-loan/%s', $this->path, $fc->getId(), $fl->getId()),
        );

        $response = $this->client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $responseData = json_decode($response->getContent(), true);
        $this->assertTrue($responseData['ok']);

        $cl = $this->customerLoansRepo->findOneBy(['customerId' => $fc->getId()]);
        $this->assertEquals($fl->getId(), $cl->getLoanId());
        $this->assertEquals($fl->getPercent() + 11.4, $cl->getPercent());

        $deuDate = (new \DateTime())->add(new \DateInterval(sprintf('P%sD', $fl->getTermDays())));
        $this->assertEquals($deuDate->format('Y-m-d'), $cl->getDueDate()->format('Y-m-d'));
    }
}
