<?php

namespace App\Test\Controller;

use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CustomerControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/customer/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Customer::class);

        foreach ($this->repository->findAll() as $object) {
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
                'address' => 'NY, NY, 2208',
                'ssn' => '1234t5667',
                'fico' => 300,
                'email' => 'test@email.com',
                'phoneNumber' => '+105999873',
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
        $fixture->setAddress('My Title');
        $fixture->setSsn('My Title');
        $fixture->setFico(300);
        $fixture->setEmail('My Title');
        $fixture->setPhoneNumber('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $fixture = new Customer();
        $fixture->setLastName('Value');
        $fixture->setFirstName('Value');
        $fixture->setBirthDate(new \DateTime());
        $fixture->setAddress('Value');
        $fixture->setSsn('Value');
        $fixture->setFico(300);
        $fixture->setEmail('Value');
        $fixture->setPhoneNumber('Value');

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
                'address' => 'NY, NY, 2208',
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
        self::assertSame('NY, NY, 2208', $fixture[0]->getAddress());
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
        $fixture->setAddress('Value');
        $fixture->setSsn('Value');
        $fixture->setFico(300);
        $fixture->setEmail('Value');
        $fixture->setPhoneNumber('Value');

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
        self::assertSame('Value', $fixture[0]->getAddress());
        self::assertSame('Value', $fixture[0]->getSsn());
        self::assertSame(300, $fixture[0]->getFico());
        self::assertSame('Value', $fixture[0]->getEmail());
        self::assertSame('Value', $fixture[0]->getPhoneNumber());
    }
}
