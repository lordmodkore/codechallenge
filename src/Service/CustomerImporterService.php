<?php

// src/Service/CustomerImporterService.php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Customer;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CustomerImporterService
{

	private $httpClient;
	private $entityManager;

	public function __construct(HttpClientInterface $httpClient, EntityManagerInterface $entityManager)
	{
		$this->httpClient = $httpClient;
		$this->entityManager = $entityManager;
	}

	public function importCustomers()
	{
		$response = $this->httpClient->request('GET', 'https://randomuser.me/api/', [
			'query' => ['results' => 100, 'nat' => 'AU']
		]);

		$data = $response->toArray();
		$customers = $data['results'];

		$customerEntities = array_map(function ($customer) {
			return (new Customer())
				->setFirstName($customer['name']['first'])
				->setLastName($customer['name']['last'])
				->setEmail($customer['email'])
				->setCountry($customer['nat'])
				->setUsername($customer['login']['username'])
				->setGender($customer['gender'])
				->setCity($customer['location']['city'])
				->setPhone($customer['phone'])
				->setPassword(md5($customer['login']['password']));
		}, $customers);

		array_walk($customerEntities, function ($customerEntity) {
			$existingCustomer = $this->entityManager->getRepository(Customer::class)
			                                        ->findOneBy(['email' => $customerEntity->getEmail()]);

			if ($existingCustomer) {
				// Update existing customer
				$existingCustomer->setFirstName($customerEntity->getFirstName())
				                 ->setLastName($customerEntity->getLastName())
				                 ->setCountry($customerEntity->getCountry())
				                 ->setUsername($customerEntity->getUsername())
				                 ->setGender($customerEntity->getGender())
				                 ->setCity($customerEntity->getCity())
				                 ->setPhone($customerEntity->getPhone())
				                 ->setPassword($customerEntity->getPassword());
			} else {
				// Add new customer
				$this->entityManager->persist($customerEntity);
			}
		});

		$this->entityManager->flush();
	}
}